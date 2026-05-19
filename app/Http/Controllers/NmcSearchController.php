<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Services\NmcApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NmcSearchController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name', '');
        $smc = $request->input('smc', '');
        $page = max(1, (int) $request->input('page', 1));
        $perPage = 15;
        $start = ($page - 1) * $perPage;

        $doctors = [];
        $total = 0;
        $apiError = false;
        $usingFallback = false;
        $smcList = NmcApiService::getSmcList();

        // Only call API if user initiated a search OR is browsing (page > 1)
        $searching = $request->has('search') || $page > 1;

        if ($searching) {
            try {
                $service = new NmcApiService();
                $result = $service->searchDoctors($start, $perPage);
                $allDoctors = $result['doctors'];
                $total = $result['total'];

                // Client-side filtering since NMC API doesn't support filters on getPaginatedData
                if ($name || $smc) {
                    // For filtered searches, fetch a larger batch and filter client-side
                    // This is a tradeoff — NMC doesn't support server-side name/smc filtering
                    // on the paginated endpoint
                    $filteredDoctors = collect($allDoctors);

                    if ($name) {
                        $filteredDoctors = $filteredDoctors->filter(function ($doc) use ($name) {
                            return stripos($doc['name'], $name) !== false;
                        });
                    }

                    if ($smc) {
                        $filteredDoctors = $filteredDoctors->filter(function ($doc) use ($smc, $smcList) {
                            $smcName = $smcList[(int) $smc] ?? '';
                            return stripos($doc['state_medical_council'], $smcName) !== false;
                        });
                    }

                    $doctors = $filteredDoctors->values()->all();
                    // When filtering, we can't know exact total from API
                    $total = count($doctors) > 0 ? $total : 0;
                } else {
                    $doctors = $allDoctors;
                }
            } catch (\Exception $e) {
                Log::warning('NMC API failed, using fallback: ' . $e->getMessage());
                $apiError = true;
                $usingFallback = true;

                // Fallback to local doctors
                $query = Doctor::query();
                if ($name) {
                    $query->where('name', 'like', "%{$name}%");
                }
                $localDoctors = $query->latest()->get();

                // Convert local doctors to same format as NMC
                $doctors = $localDoctors->map(function ($doc) {
                    return [
                        'row_num' => $doc->id,
                        'year' => $doc->created_at?->year ?? '—',
                        'registration_number' => 'LOCAL-' . $doc->id,
                        'state_medical_council' => 'Local Directory',
                        'name' => $doc->name,
                        'father_name' => '',
                        'doctor_id' => '',
                        'profile_url' => '',
                        'specialization' => $doc->specialization,
                        'availability' => $doc->availability,
                        'email' => $doc->email,
                        'phone' => $doc->phone,
                    ];
                })->all();
                $total = count($doctors);
            }
        }

        $totalPages = $total > 0 ? ceil($total / $perPage) : 1;

        return view('nmc.search', compact(
            'doctors', 'total', 'page', 'totalPages', 'perPage',
            'name', 'smc', 'smcList', 'searching',
            'apiError', 'usingFallback'
        ));
    }
}

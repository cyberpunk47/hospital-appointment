<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
class NmcSearchController extends Controller
{
    public function index(Request $request)
    {
        $specialization = $request->input('specialization', '');
        $state = $request->input('state', '');
        $city = $request->input('city', '');
        $date = $request->input('date', Carbon::today()->toDateString());
        
        $specializations = Doctor::distinct()->whereNotNull('specialization')->pluck('specialization')->toArray();
        $statesAndCities = config('indian_cities', []);
        
        $searching = $request->has('search') || $specialization || $state || $city;
        
        $allowedSortFields = ['name', 'specialization', 'city', 'daily_limit', 'start_time'];
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'name';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $query = Doctor::query();
        
        if ($specialization) {
            $query->where('specialization', $specialization);
        }
        if ($state) {
            $query->where('state', $state);
        }
        if ($city) {
            $query->where('city', $city);
        }
        
        $doctors = $query->orderBy($sortBy, $sortOrder)->paginate(6)->withQueryString();
        
        // Enhance each doctor with timings and remaining slots on the selected date
        $doctors->getCollection()->transform(function ($doc) use ($date) {
            $bookedCount = Appointment::where('doctor_id', $doc->id)
                ->where('appointment_date', $date)
                ->where('status', '!=', 'Cancelled')
                ->count();
                
            $doc->booked_count = $bookedCount;
            $doc->slots_remaining = max(0, $doc->daily_limit - $bookedCount);
            
            // Format timings for display
            try {
                $start = Carbon::createFromFormat('H:i:s', $doc->start_time)->format('h:i A');
            } catch (\Exception $e) {
                try {
                    $start = Carbon::createFromFormat('H:i', $doc->start_time)->format('h:i A');
                } catch (\Exception $ex) {
                    $start = $doc->start_time;
                }
            }

            try {
                $end = Carbon::createFromFormat('H:i:s', $doc->end_time)->format('h:i A');
            } catch (\Exception $e) {
                try {
                    $end = Carbon::createFromFormat('H:i', $doc->end_time)->format('h:i A');
                } catch (\Exception $ex) {
                    $end = $doc->end_time;
                }
            }

            $doc->formatted_timings = "$start - $end";
            
            return $doc;
        });
        
        $patients = Patient::orderBy('name')->get();
        
        return view('nmc.search', compact(
            'doctors',
            'specialization',
            'state',
            'city',
            'date',
            'specializations',
            'statesAndCities',
            'searching',
            'patients',
            'sortBy',
            'sortOrder'
        ));
    }
}

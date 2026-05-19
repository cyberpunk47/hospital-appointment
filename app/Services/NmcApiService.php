<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NmcApiService
{
    private string $baseUrl = 'https://www.nmc.org.in/MCIRest/open';

    /**
     * Search the NMC Indian Medical Register.
     * Uses the paginated listing endpoint.
     *
     * Response format from NMC:
     * data: [[rowNum, year, regNo, smcName, doctorName, fatherName, viewLink], ...]
     */
    public function searchDoctors(int $start = 0, int $length = 10): array
    {
        $cacheKey = "nmc_doctors_{$start}_{$length}";

        // Cache results for 30 minutes to avoid hammering the slow API
        return Cache::remember($cacheKey, 1800, function () use ($start, $length) {
            return $this->fetchFromApi($start, $length);
        });
    }

    private function fetchFromApi(int $start, int $length): array
    {
        $url = "{$this->baseUrl}/getPaginatedData";

        $response = Http::withoutVerifying()
            ->timeout(45)
            ->connectTimeout(15)
            ->retry(2, 5000)
            ->get($url, [
                'service' => 'getPaginatedDoctor',
                'draw' => 1,
                'start' => $start,
                'length' => $length,
            ]);

        if (!$response->successful()) {
            throw new \Exception('NMC API returned status: ' . $response->status());
        }

        $json = $response->json();

        if (!isset($json['data']) || !is_array($json['data'])) {
            throw new \Exception('Invalid response format from NMC API');
        }

        return [
            'doctors' => $this->parseRecords($json['data']),
            'total' => $json['recordsTotal'] ?? 0,
            'filtered' => $json['recordsFiltered'] ?? 0,
        ];
    }

    /**
     * Parse raw DataTables array rows into structured records.
     * Row format: [rowNum, year, regNo, smcName, doctorName, fatherName, viewLink]
     */
    private function parseRecords(array $rows): array
    {
        $doctors = [];

        foreach ($rows as $row) {
            if (!is_array($row) || count($row) < 6) {
                continue;
            }

            // Extract doctor ID from the view link HTML
            $doctorId = '';
            if (isset($row[6]) && preg_match("/openDoctorDetailsnew\('(\d+)'/", $row[6], $matches)) {
                $doctorId = $matches[1];
            }

            $doctors[] = [
                'row_num' => $row[0] ?? '',
                'year' => $row[1] ?? '',
                'registration_number' => $row[2] ?? '',
                'state_medical_council' => $row[3] ?? '',
                'name' => $row[4] ?? '',
                'father_name' => $row[5] ?? '',
                'doctor_id' => $doctorId,
                'profile_url' => $doctorId
                    ? "https://www.nmc.org.in/information-desk/indian-medical-register/#doctorId={$doctorId}&regNo=" . ($row[2] ?? '')
                    : '',
            ];
        }

        return $doctors;
    }

    /**
     * Get full list of State Medical Council options for filtering.
     */
    public static function getSmcList(): array
    {
        return [
            1 => 'Andhra Pradesh Medical Council',
            2 => 'Arunachal Pradesh Medical Council',
            3 => 'Assam Medical Council',
            4 => 'Bihar Medical Council',
            5 => 'Chhattisgarh Medical Council',
            6 => 'Delhi Medical Council',
            7 => 'Goa Medical Council',
            8 => 'Gujarat Medical Council',
            9 => 'Haryana Medical Council',
            10 => 'Himachal Pradesh Medical Council',
            11 => 'Jammu & Kashmir Medical Council',
            12 => 'Jharkhand Medical Council',
            13 => 'Karnataka Medical Council',
            14 => 'Kerala Medical Council',
            15 => 'Madhya Pradesh Medical Council',
            16 => 'Maharashtra Medical Council',
            17 => 'Manipur Medical Council',
            18 => 'Meghalaya Medical Council',
            19 => 'Mizoram Medical Council',
            20 => 'Nagaland Medical Council',
            21 => 'Tamil Nadu Medical Council',
            22 => 'Telangana State Medical Council',
            23 => 'Uttar Pradesh Medical Council',
            24 => 'Uttarakhand Medical Council',
            25 => 'West Bengal Medical Council',
            26 => 'Odisha Medical Council',
            27 => 'Punjab Medical Council',
            28 => 'Rajasthan Medical Council',
            29 => 'Sikkim Medical Council',
            30 => 'Tripura Medical Council',
        ];
    }
}

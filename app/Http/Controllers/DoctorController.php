<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $allowedSortFields = ['id', 'name', 'specialization', 'city', 'state', 'daily_limit', 'availability', 'license_number'];
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'id';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $search = $request->input('search', '');
        $query = Doctor::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%");
            });
        }

        $doctors = $query->orderBy($sortBy, $sortOrder)->paginate(10)->withQueryString();

        return view('doctors.index', compact('doctors', 'sortBy', 'sortOrder', 'search'));
    }

    public function create()
    {
        $indianCities = config('indian_cities', []);
        $states = array_keys($indianCities);
        return view('doctors.create', compact('indianCities', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:15',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:doctors,license_number',
            'availability' => 'required|in:Available,Unavailable',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'daily_limit' => 'required|integer|min:1',
            'address' => 'nullable|string',
        ]);

        $data = $request->all();
        if (isset($data['start_time']) && strlen($data['start_time']) === 5) {
            $data['start_time'] .= ':00';
        }
        if (isset($data['end_time']) && strlen($data['end_time']) === 5) {
            $data['end_time'] .= ':00';
        }

        Doctor::create($data);
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('appointments.patient');
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $indianCities = config('indian_cities', []);
        $states = array_keys($indianCities);
        return view('doctors.edit', compact('doctor', 'indianCities', 'states'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'required|string|max:15',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:doctors,license_number,' . $doctor->id,
            'availability' => 'required|in:Available,Unavailable',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'daily_limit' => 'required|integer|min:1',
            'address' => 'nullable|string',
        ]);

        $data = $request->all();
        if (isset($data['start_time']) && strlen($data['start_time']) === 5) {
            $data['start_time'] .= ':00';
        }
        if (isset($data['end_time']) && strlen($data['end_time']) === 5) {
            $data['end_time'] .= ':00';
        }

        $doctor->update($data);
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Poli;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('poli')->latest()->get();
        return view('admin.doctors.index', compact('doctors')); // asumsi pakai Blade view
    }

    public function create()
    {
        $polis = Poli::all();
        return view('admin.doctors.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id',
            'status' => 'required|in:active,inactive',
            'schedule' => 'nullable|array',
        ]);

        // Menyimpan jadwal sebagai array
        $doctor = Doctor::create([
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'poli_id' => $validated['poli_id'],
            'status' => $validated['status'],
            'schedule' => $validated['schedule'] ?? [],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor)
    {
        $schedule = $doctor->schedule ?? [];
        return view('admin.doctors.show', compact('doctor', 'schedule'));
    }

    public function edit(Doctor $doctor)
    {
        $polis = Poli::all();
        $schedule = $doctor->schedule ?? [];
        return view('admin.doctors.edit', compact('doctor', 'polis', 'schedule'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id',
            'status' => 'required|in:active,inactive',
            'schedule' => 'nullable|array',
        ]);

        $doctor->update([
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'poli_id' => $validated['poli_id'],
            'status' => $validated['status'],
            'schedule' => $validated['schedule'] ?? [],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}

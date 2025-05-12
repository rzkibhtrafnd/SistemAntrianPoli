<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'medical_record' => 'nullable|string',
        ]);

        // Generate nomor registrasi unik
        $validated['registration_number'] = 'P' . date('Ymd') . rand(1000, 9999);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'medical_record' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }

    public function printCard(Patient $patient)
    {
        $qrCode = QrCode::size(200)->generate($patient->registration_number);
        return view('admin.patients.card', compact('patient', 'qrCode'));
    }

    public function downloadCard(Patient $patient)
    {
        $qrCode = QrCode::size(200)->generate($patient->registration_number);
        $pdf = Pdf::loadView('admin.patients.card-pdf', compact('patient', 'qrCode'));
        return $pdf->download('kartu-pasien-' . $patient->registration_number . '.pdf');
    }
}

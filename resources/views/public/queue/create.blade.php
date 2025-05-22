@extends('layouts.app')

@section('title', 'Daftar Antrian')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-semibold mb-6">Form Pendaftaran Antrian</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('queues.store') }}" method="POST">
        @csrf

        {{-- Pilih Pasien --}}
        <label for="registration_number" class="block font-medium mb-1">Pasien</label>
        <select name="registration_number" id="registration_number" class="w-full border rounded p-2 mb-4" required>
            <option value="">-- Pilih Pasien --</option>
            @foreach ($patients as $patient)
                <option value="{{ $patient->registration_number }}"
                    {{ old('registration_number') == $patient->registration_number ? 'selected' : '' }}>
                    {{ $patient->name }} ({{ $patient->registration_number }})
                </option>
            @endforeach
        </select>

        {{-- Pilih Poli --}}
        <label for="poli_id" class="block font-medium mb-1">Poli</label>
        <select name="poli_id" id="poli_id" class="w-full border rounded p-2 mb-4" required>
            <option value="">-- Pilih Poli --</option>
            @foreach ($polis as $poli)
                <option value="{{ $poli->id }}"
                    {{ old('poli_id', $selectedPoliId) == $poli->id ? 'selected' : '' }}>
                    {{ $poli->name }}
                </option>
            @endforeach
        </select>

        {{-- Pilih Dokter --}}
        <label for="doctor_id" class="block font-medium mb-1">Dokter</label>
        <select name="doctor_id" id="doctor_id" class="w-full border rounded p-2 mb-4" required>
            <option value="">-- Pilih Dokter --</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}"
                    {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }} ({{ $doctor->specialization }})
                </option>
            @endforeach
        </select>

        {{-- Pilih Waktu --}}
        <label for="schedule_time" class="block font-medium mb-1">Waktu Praktek</label>
        <select name="schedule_time" id="schedule_time" class="w-full border rounded p-2 mb-6" required>
            <option value="">-- Pilih Waktu --</option>
            @foreach ($availableTimes as $time)
                <option value="{{ $time }}"
                    {{ old('schedule_time', $selectedTime) == $time ? 'selected' : '' }}>
                    {{ $time }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Daftar Antrian
        </button>
    </form>
</div>
<script>
    // Dynamic doctor selection
    document.getElementById('poli_id').addEventListener('change', function() {
        const poliId = this.value;
        const doctorSelect = document.getElementById('doctor_id');
        const timeSelect = document.getElementById('schedule_time');

        doctorSelect.innerHTML = '<option value="">Loading...</option>';
        timeSelect.innerHTML = '<option value="">-- Pilih Waktu --</option>';

        fetch(`/queues/getDoctors/${poliId}`)
            .then(response => response.json())
            .then(doctors => {
                doctorSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
                doctors.forEach(doctor => {
                    const option = new Option(
                        `${doctor.name} (${doctor.specialization})`,
                        doctor.id
                    );
                    doctorSelect.appendChild(option);
                });
            });
    });

    // Dynamic schedule selection
    document.getElementById('doctor_id').addEventListener('change', function() {
        const doctorId = this.value;
        const timeSelect = document.getElementById('schedule_time');

        timeSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/queues/getSchedule/${doctorId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(times => {
                timeSelect.innerHTML = '<option value="">-- Pilih Waktu --</option>';

                if (times.error) {
                    timeSelect.innerHTML = `<option value="">${times.error}</option>`;
                    return;
                }

                times.forEach(time => {
                    const option = new Option(time, time);
                    timeSelect.appendChild(option);
                });
            })
            .catch(error => {
                timeSelect.innerHTML = '<option value="">Gagal memuat jadwal</option>';
                console.error('Error:', error);
            });
    });
</script>
@endsection

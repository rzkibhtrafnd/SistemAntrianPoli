@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pendaftaran Antrian Pasien</h2>
                        <p class="text-blue-100 mt-1">Silakan lengkapi form pendaftaran berikut</p>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Body Content -->
            <div class="p-6 sm:p-8">
                @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-md flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                <!-- Filter Form -->
                <form method="GET" action="{{ route('queues.create') }}" class="space-y-6">
                    <!-- Poli Selection -->
                    <div>
                        <label for="poli_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <span>Pilih Poli</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="poli_id" id="poli_id" class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 @error('poli_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Poli --</option>
                                @foreach($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('poli_id', $selectedPoliId) == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('poli_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Doctor Selection (Conditional) -->
                    @if($selectedPoliId)
                    <div class="transition-all duration-300 ease-in-out">
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <span>Pilih Dokter</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="doctor_id" id="doctor_id" class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 @error('doctor_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} - {{ $doctor->specialization }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('doctor_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    @endif

                    <!-- Schedule Selection (Conditional) -->
                    @if($selectedDoctorId)
                    <div class="transition-all duration-300 ease-in-out">
                        @if(count($availableTimes) > 0)
                        <label for="schedule_time" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <span>Pilih Waktu Praktek</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="schedule_time" id="schedule_time" class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 @error('schedule_time') border-red-500 @enderror" required>
                                <option value="">-- Pilih Waktu --</option>
                                @foreach($availableTimes as $time)
                                <option value="{{ $time }}" {{ old('schedule_time', $selectedTime) == $time ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('schedule_time')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        @else
                        <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-700 rounded-md flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                @if(count($availableTimes) === 0)
                                <p class="font-medium">Pendaftaran untuk hari ini sudah ditutup</p>
                                <p class="text-sm mt-1">Silakan kembali besok atau pilih dokter lain</p>
                                @else
                                <p class="font-medium">Tidak ada jadwal tersedia</p>
                                <p class="text-sm mt-1">Dokter ini tidak memiliki jadwal praktek hari ini</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </form>

                <!-- Registration Form (Conditional) -->
                @if($selectedPoliId && $selectedDoctorId && $selectedTime)
                <form method="POST" action="{{ route('queues.store') }}" class="mt-8 space-y-6">
                    @csrf
                    <input type="hidden" name="poli_id" value="{{ $selectedPoliId }}">
                    <input type="hidden" name="doctor_id" value="{{ $selectedDoctorId }}">
                    <input type="hidden" name="schedule_time" value="{{ $selectedTime }}">

                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <span>Nomor Registrasi Pasien</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number') }}"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('registration_number') border-red-500 @enderror"
                                placeholder="Masukkan nomor registrasi"
                                required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="startScanner()" class="text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('registration_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-sm text-gray-500">Scan QR code kartu pasien jika tersedia</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="bg-blue-50 px-4 py-3 rounded-lg">
                                <p class="text-sm text-gray-600">Waktu terpilih:</p>
                                <p class="font-semibold text-blue-700">{{ $selectedTime }}</p>
                            </div>
                            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Daftar & Cetak Antrian
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div id="scanner-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-75">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Scan Kartu Pasien</h3>
            <button onclick="closeScanner()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="qr-reader" class="w-full h-64 border-2 border-dashed border-gray-300 rounded-lg mb-4"></div>
        <p class="text-sm text-gray-500 text-center">Arahkan kamera ke QR code pada kartu pasien</p>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrCode;

    function startScanner() {
        const modal = document.getElementById('scanner-modal');
        modal.classList.remove('hidden');

        html5QrCode = new Html5Qrcode("qr-reader");
        const config = { fps: 10, qrbox: 250 };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText) => {
                document.getElementById('registration_number').value = decodedText;
                closeScanner();
            },
            (errorMessage) => {
                // Handle scan error
            }
        ).catch((err) => {
            console.error("Error starting scanner:", err);
            alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
            closeScanner();
        });
    }

    function closeScanner() {
        if (html5QrCode && html5QrCode.isRunning()) {
            html5QrCode.stop().then(() => {
                document.getElementById('scanner-modal').classList.add('hidden');
            }).catch((err) => {
                console.error("Error stopping scanner:", err);
            });
        } else {
            document.getElementById('scanner-modal').classList.add('hidden');
        }
    }
</script>
@endpush

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
@endsection

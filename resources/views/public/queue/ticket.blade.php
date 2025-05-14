@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">{{ config('app.name', 'Klinik Sehat') }}</h1>
                    <p class="text-sm opacity-90">Rumah Sakit Gen Z abizzz</p>
                </div>
                <div class="text-right">
                    <p class="text-xs">Tanggal: {{ now()->format('d/m/Y') }}</p>
                    <p class="text-xs">Jam: {{ now()->format('H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6">
            <!-- Nomor Antrian -->
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-1">Nomor Antrian</p>
                <div class="inline-block px-6 py-2 bg-red-100 rounded-full">
                    <span class="text-3xl font-bold text-red-600">{{ $queue->queue_number }}</span>
                </div>
            </div>

            <!-- Detail Pasien -->
            <div class="space-y-3 mb-6">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Nama Pasien:</span>
                    <span class="font-medium">{{ $queue->patient->name }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Poli Tujuan:</span>
                    <span class="font-medium text-blue-600">{{ $queue->poli->name }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Dokter:</span>
                    <span class="font-medium">{{ $queue->doctor->name }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Waktu Praktek:</span>
                    <span class="font-medium">{{ Carbon\Carbon::parse($queue->schedule_time)->format('H:i') }}</span>
                </div>
            </div>

            <!-- Instruksi -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <p class="text-sm text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                    Harap datang 15 menit sebelum waktu pemeriksaan
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-3 text-center">
            <p class="text-xs text-gray-500">Terima kasih atas kunjungan Anda</p>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="mt-6 text-center">
        <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm">
            Cetak Struk
        </button>
    </div>
</div>

<style>
    @media print {
        button {
            display: none;
        }
        body {
            padding: 0;
            margin: 0;
        }
    }
</style>
@endsection

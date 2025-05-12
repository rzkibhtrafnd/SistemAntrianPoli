@extends('layouts.admin')

@section('title', 'Detail Pasien')

@section('content')
<div class="container mx-auto max-w-4xl py-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800">Detail Pasien</h1>
      <p class="text-sm text-gray-500 mt-1">{{ $patient->registration_number }}</p>
    </div>
    <div class="flex items-center space-x-3">
      <a href="{{ route('patients.index') }}"
         class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
        <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
      </a>
      <a href="{{ route('patients.edit', $patient->id) }}"
         class="inline-flex items-center px-4 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">
        <i data-feather="edit" class="w-4 h-4 mr-2"></i> Edit
      </a>
    </div>
  </div>

  <!-- Card Detail -->
  <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
      <div class="p-6 space-y-4">
        <div>
          <span class="block text-xs font-semibold text-gray-500">Nama Lengkap</span>
          <p class="text-lg font-medium text-gray-800">{{ $patient->name }}</p>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-500">Jenis Kelamin</span>
          <p class="text-lg text-gray-800">{{ $patient->gender }}</p>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-500">Tanggal Lahir</span>
          <p class="text-lg text-gray-800">
            {{ \Carbon\Carbon::parse($patient->birth_date)->isoFormat('D MMMM Y') }}
            <span class="text-sm text-gray-500">({{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun)</span>
          </p>
        </div>
      </div>
      <div class="p-6 space-y-4">
        <div>
          <span class="block text-xs font-semibold text-gray-500">Nomor Telepon</span>
          <p class="text-lg text-gray-800">{{ $patient->phone }}</p>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-500">Alamat</span>
          <p class="text-lg text-gray-800 whitespace-pre-wrap">{{ $patient->address }}</p>
        </div>
      </div>
    </div>

    <!-- Medical Record -->
    @if($patient->medical_record)
      <div class="p-6 border-t border-gray-200 bg-gray-50">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">📋 Catatan Medis</h3>
        <div class="prose prose-sm text-gray-800">
          {!! nl2br(e($patient->medical_record)) !!}
        </div>
      </div>
    @endif

    <!-- Actions -->
    <div class="p-6 border-t border-gray-200 flex flex-wrap gap-3 bg-white">
      <a href="{{ route('patients.print-card', $patient->id) }}" target="_blank"
         class="inline-flex items-center px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i data-feather="printer" class="w-4 h-4 mr-2"></i> Cetak Kartu
      </a>
      <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
            onsubmit="return confirm('Hapus pasien ini?')">
        @csrf @method('DELETE')
        <button type="submit"
          class="inline-flex items-center px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
          <i data-feather="trash-2" class="w-4 h-4 mr-2"></i> Hapus Pasien
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

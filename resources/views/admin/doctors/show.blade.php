@extends('layouts.admin')

@section('title', 'Detail Dokter')

@section('content')
<div class="container mx-auto max-w-4xl py-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800">Detail Dokter</h1>
      <p class="text-sm text-gray-500 mt-1">Spesialisasi: {{ $doctor->specialization }}</p>
    </div>
    <div class="flex items-center space-x-3">
      <a href="{{ route('doctors.index') }}"
         class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
        <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
      </a>
      <a href="{{ route('doctors.edit', $doctor->id) }}"
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
          <p class="text-lg font-medium text-gray-800">{{ $doctor->name }}</p>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-500">Poli</span>
          <p class="text-lg text-gray-800">{{ $doctor->poli->name }}</p>
        </div>
      </div>
      <div class="p-6 space-y-4">
        <div>
          <span class="block text-xs font-semibold text-gray-500">Status</span>
          <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $doctor->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ ucfirst($doctor->status) }}
          </span>
        </div>
      </div>
    </div>

    <!-- Jadwal Dokter -->
    <div class="p-6 border-t border-gray-200 bg-gray-50">
      <h3 class="text-sm font-semibold text-gray-700 mb-3">🕒 Jadwal Praktik</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
          @php $schedule = $doctor->schedule[$day] ?? [null, null] @endphp
          <div class="bg-white p-3 rounded-lg shadow-sm">
            <span class="block text-xs font-semibold text-gray-500">{{ $day }}</span>
            <p class="text-sm text-gray-800 mt-1">
              @if($schedule[0] && $schedule[1])
                {{ $schedule[0] }} - {{ $schedule[1] }}
              @else
                <span class="text-gray-400">Libur</span>
              @endif
            </p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

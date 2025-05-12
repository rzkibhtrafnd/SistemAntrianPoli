@extends('layouts.admin')

@section('title', 'Tambah Dokter Baru')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Tambah Dokter Baru</h3>
      <p class="text-gray-500">Isi formulir berikut untuk menambahkan dokter baru</p>
    </div>
    <a href="{{ route('doctors.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>
  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('doctors.store') }}" method="POST" class="space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Dokter *</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror" required>
          @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="specialization" class="block text-sm font-medium text-gray-700">Spesialisasi *</label>
          <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('specialization') border-red-500 @enderror" required>
          @error('specialization')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="poli_id" class="block text-sm font-medium text-gray-700">Poli *</label>
          <select id="poli_id" name="poli_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('poli_id') border-red-500 @enderror" required>
            <option value="">Pilih Poli</option>
            @foreach ($polis as $poli)
              <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
            @endforeach
          </select>
          @error('poli_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
          <select id="status" name="status" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('status') border-red-500 @enderror" required>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
          @error('status')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Jadwal Dokter *</label>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
            <div>
              <label for="schedule_{{ $day }}" class="block text-sm font-medium text-gray-700">{{ $day }}</label>
              <input type="time" name="schedule[{{ $day }}][]" id="schedule_{{ $day }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Jam kerja">
              <input type="time" name="schedule[{{ $day }}][]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 mt-2" placeholder="Jam kerja">
            </div>
          @endforeach
        </div>
        @error('schedule')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="text-right">
        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Data Dokter
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

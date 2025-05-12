@extends('layouts.admin')

@section('title', 'Edit Data Pasien')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Edit Data Pasien</h3>
      <p class="text-gray-500">Perbarui informasi pasien di bawah ini</p>
    </div>
    <a href="{{ route('patients.show', $patient->id) }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali ke Detail
    </a>
  </div>
  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
          <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror" required>
          @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin *</label>
            <select id="gender" name="gender" required
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('gender') border-red-500 @enderror">
            <option value="">Pilih</option>
            <option value="Laki-laki" {{ old('gender', $patient->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('gender', $patient->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
          @error('gender')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir *</label>
        <input type="date" name="birth_date" id="birth_date"
            value="{{ old('birth_date', \Carbon\Carbon::parse($patient->birth_date)->format('Y-m-d')) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('birth_date') border-red-500 @enderror" required>
        @error('birth_date')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon *</label>
          <input type="tel" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('phone') border-red-500 @enderror" required>
          @error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
        <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat *</label>
        <textarea name="address" id="address" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('address') border-red-500 @enderror" required>{{ old('address', $patient->address) }}</textarea>
        @error('address')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      <div>
        <label for="medical_record" class="block text-sm font-medium text-gray-700">Catatan Medis</label>
        <textarea name="medical_record" id="medical_record" rows="2"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('medical_record', $patient->medical_record) }}</textarea>
      </div>
      <div class="text-right">
        <button type="submit"
          class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

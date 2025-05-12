@extends('layouts.admin')

@section('title', 'Tambah Poli')

@section('content')
<div class="container mx-auto max-w-xl">
  <h3 class="text-xl font-semibold mb-4 text-gray-800">Form Tambah Poli</h3>
  <form action="{{ route('polis.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Nama Poli</label>
      <input type="text" name="name" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('name') }}">
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
      <textarea name="description" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('description') }}</textarea>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Status</label>
      <select name="status" class="w-full border rounded px-3 py-2 mt-1" required>
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
      </select>
    </div>
    <div class="flex justify-end">
      <a href="{{ route('polis.index') }}" class="px-4 py-2 mr-2 bg-gray-300 text-gray-700 rounded">Batal</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    </div>
  </form>
</div>
@endsection

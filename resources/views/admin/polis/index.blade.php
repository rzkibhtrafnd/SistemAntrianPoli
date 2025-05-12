@extends('layouts.admin')

@section('title', 'Manajemen Poli')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Poli</h3>
    <a href="{{ route('polis.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah Poli
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
  @endif

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Poli</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dokter</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($polis as $poli)
        <tr>
          <td class="px-6 py-4 text-sm text-gray-800">{{ $poli->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $poli->description }}</td>
          <td class="px-6 py-4 text-sm">
            <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $poli->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
              {{ ucfirst($poli->status) }}
            </span>
          </td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $poli->doctors->count() }}</td>
          <td class="px-6 py-4 text-sm">
            <div class="flex space-x-2">
              <a href="{{ route('polis.show', $poli->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
              <a href="{{ route('polis.edit', $poli->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
              <form action="{{ route('polis.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Hapus data poli ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

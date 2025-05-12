@extends('layouts.admin')

@section('title','Manajemen Dokter')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Dokter</h3>
    <a href="{{ route('doctors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Dokter Baru
    </a>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($doctors as $doctor)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $doctor->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $doctor->specialization }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $doctor->poli->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doctor->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
              {{ ucfirst($doctor->status) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            <div class="flex space-x-2">
              <a href="{{ route('doctors.show', $doctor->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
              <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
              <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Hapus dokter ini?')">
                @csrf
                @method('DELETE')
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

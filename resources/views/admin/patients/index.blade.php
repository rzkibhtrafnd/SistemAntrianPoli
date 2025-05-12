@extends('layouts.admin')

@section('title','Manajemen Pasien')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Pasien</h3>
    <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Pasien Baru
    </a>
  </div>
  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Registrasi</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usia</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($patients as $patient)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->registration_number }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $patient->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->gender }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            <div class="flex space-x-2">
              <a href="{{ route('patients.show',$patient->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
              <a href="{{ route('patients.edit',$patient->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
              <form action="{{ route('patients.destroy',$patient->id) }}" method="POST" onsubmit="return confirm('Hapus data pasien?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
              </form>
              <a href="{{ route('patients.print-card',$patient->id) }}" target="_blank" class="text-green-600 hover:text-green-800">Cetak Kartu</a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $patients->links('pagination::tailwind') }}</div>
</div>
@endsection

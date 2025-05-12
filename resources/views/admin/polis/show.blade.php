@extends('layouts.admin')

@section('title', 'Detail Poli')

@section('content')
<div class="container mx-auto max-w-4xl py-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800">Detail Poli</h1>
      <p class="text-sm text-gray-500 mt-1">{{ $poli->description ?? 'Tidak ada deskripsi' }}</p>
    </div>
    <div class="flex items-center space-x-3">
      <a href="{{ route('polis.index') }}"
         class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
        <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
      </a>
      <a href="{{ route('polis.edit', $poli->id) }}"
         class="inline-flex items-center px-4 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">
        <i data-feather="edit" class="w-4 h-4 mr-2"></i> Edit
      </a>
    </div>
  </div>

  <!-- Card Detail -->
  <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-200">
      <span class="block text-xs font-semibold text-gray-500">Status Poli</span>
      <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $poli->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
        {{ ucfirst($poli->status) }}
      </span>
    </div>

    <!-- Daftar Dokter -->
    <div class="p-6 bg-gray-50">
      <h3 class="text-sm font-semibold text-gray-700 mb-4">👨⚕️ Dokter Tersedia</h3>
      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spesialisasi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($poli->doctors as $doctor)
            <tr>
              <td class="px-6 py-4 text-sm text-gray-800">{{ $doctor->name }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ $doctor->specialization }}</td>
              <td class="px-6 py-4 text-sm">
                <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $doctor->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                  {{ ucfirst($doctor->status) }}
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada dokter</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>feather.replace()</script>
@endpush

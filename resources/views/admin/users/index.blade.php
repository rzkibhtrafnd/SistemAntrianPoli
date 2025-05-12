@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h3>
    <a href="{{ route('users.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Pengguna Baru
    </a>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($users as $user)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">{{ $user->role }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ $user->poli->name ?? '-' }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            <div class="flex space-x-2">
              <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
              <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Hapus pengguna ini?')">
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

@extends('layouts.admin')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Edit Data Pengguna</h3>
      <p class="text-gray-500">Perbarui informasi pengguna di bawah ini</p>
    </div>
    <a href="{{ route('users.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
          <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror" required>
          @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
          <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('email') border-red-500 @enderror" required>
          @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
          <input type="password" name="password" id="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('password') border-red-500 @enderror">
          @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
          <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
          <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
          <select id="role" name="role"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('role') border-red-500 @enderror" required>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
          </select>
          @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="poli_id" class="block text-sm font-medium text-gray-700">Poli (Untuk Staff)</label>
          <select id="poli_id" name="poli_id"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('poli_id') border-red-500 @enderror">
            <option value="">Pilih Poli</option>
            @foreach ($polis as $poli)
              <option value="{{ $poli->id }}" {{ old('poli_id', $user->poli_id) == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
            @endforeach
          </select>
          @error('poli_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
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

<!-- resources/views/admin/patients/card.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kartu Pasien - {{ $patient->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-cyan-50 font-[Poppins] text-gray-800">
  <div class="max-w-sm mx-auto my-10 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-teal-600 p-4 text-white text-center">
      <h1 class="text-2xl font-semibold">Kartu Pasien</h1>
      <p class="text-sm opacity-80">RS. Contoh Sehat</p>
    </div>

    {{-- Konten Utama --}}
    <div class="p-6 space-y-6">

      {{-- QR + Info --}}
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-24 h-24 bg-white rounded-xl border-2 border-dashed border-teal-200 flex items-center justify-center">
            {!! $qrCode !!}
          </div>
        </div>
        <div class="ml-4 flex-1 space-y-2">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h10m-9 4h10"/>
            </svg>
            <div>
              <p class="text-xs text-gray-500">No. Registrasi</p>
              <p class="font-medium text-gray-800">{{ $patient->registration_number }}</p>
            </div>
          </div>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c3.195 0 6.158 1.064 8.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
              <p class="text-xs text-gray-500">Nama Pasien</p>
              <p class="font-medium text-gray-800">{{ $patient->name }}</p>
            </div>
          </div>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h10m-9 4h10"/>
            </svg>
            <div>
              <p class="text-xs text-gray-500">Tanggal Lahir</p>
              <p class="font-medium text-gray-800">
                {{ \Carbon\Carbon::parse($patient->birth_date)->isoFormat('D MMMM Y') }}
                <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($patient->birth_date)->age }} thn)</span>
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- Divider --}}
      <div class="border-t border-gray-200"></div>

      {{-- Catatan Footer --}}
      <div class="text-center text-sm text-gray-500 space-y-1">
        <p class="italic">Simpan kartu ini untuk keperluan pemeriksaan selanjutnya</p>
        <p>RS. Contoh Sehat • Jl. Kesehatan No. 123 • (021) 555-1234</p>
      </div>

    </div>
  </div>
</body>
</html>

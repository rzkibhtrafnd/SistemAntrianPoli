<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kartu Pasien - {{ $patient->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    @page {
      size: 85.6mm 54mm;
      margin: 0;
    }
    body {
      width: 85.6mm;
      height: 54mm;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-cyan-50 font-[Poppins] text-gray-800">
  <div class="w-full h-full bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 flex flex-col">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-teal-600 p-2 text-white text-center">
      <h1 class="text-lg font-semibold">Kartu Pasien</h1>
      <p class="text-xs opacity-80">RS. Contoh Sehat</p>
    </div>

    {{-- Konten Utama --}}
    <div class="flex-1 p-3 flex">

      {{-- QR Code Section --}}
      <div class="flex-shrink-0 flex items-center justify-center mr-3">
        <div class="w-20 h-20 bg-white rounded-lg border border-teal-200 flex items-center justify-center p-1">
          {!! $qrCode !!}
        </div>
      </div>

      {{-- Patient Info Section --}}
      <div class="flex-1 flex flex-col justify-between">
        <div class="space-y-1.5">
          {{-- Registration Number --}}
          <div class="flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mt-0.5 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h10m-9 4h10"/>
            </svg>
            <div>
              <p class="text-[10px] text-gray-500 leading-none">No. Registrasi</p>
              <p class="text-xs font-medium text-gray-800 leading-tight">{{ $patient->registration_number }}</p>
            </div>
          </div>

          {{-- Patient Name --}}
          <div class="flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mt-0.5 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c3.195 0 6.158 1.064 8.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
              <p class="text-[10px] text-gray-500 leading-none">Nama Pasien</p>
              <p class="text-xs font-medium text-gray-800 leading-tight">{{ $patient->name }}</p>
            </div>
          </div>

          {{-- Birth Date --}}
          <div class="flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h10m-9 4h10"/>
            </svg>
            <div>
              <p class="text-[10px] text-gray-500 leading-none">Tanggal Lahir</p>
              <p class="text-xs font-medium text-gray-800 leading-tight">
                {{ \Carbon\Carbon::parse($patient->birth_date)->isoFormat('D MMMM Y') }}
                <span class="text-[10px] text-gray-500">({{ \Carbon\Carbon::parse($patient->birth_date)->age }} thn)</span>
              </p>
            </div>
          </div>

          {{-- Additional Info (if needed) --}}
          @if($patient->blood_type)
          <div class="flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 mt-0.5 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <div>
              <p class="text-[10px] text-gray-500 leading-none">Gol. Darah</p>
              <p class="text-xs font-medium text-gray-800 leading-tight">{{ $patient->blood_type }}</p>
            </div>
          </div>
          @endif
        </div>

        {{-- Footer Note --}}
        <div class="text-center">
          <p class="text-[8px] italic text-gray-400 leading-tight">Simpan kartu ini untuk keperluan pemeriksaan</p>
          <p class="text-[7px] text-gray-400 leading-tight">RS. Contoh Sehat • (021) 555-1234</p>
        </div>
      </div>
    </div>

    {{-- Hospital Logo/Watermark (optional) --}}
    <div class="absolute bottom-1 right-1 opacity-10">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
      </svg>
    </div>
  </div>
</body>
</html>

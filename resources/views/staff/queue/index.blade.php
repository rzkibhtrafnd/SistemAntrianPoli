@extends('layouts.staff')

@section('title','Antrian Poli')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Antrian Hari Ini</h3>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Antrian</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Daftar</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($queues as $queue)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ $queue->queue_number }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $queue->patient->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $queue->doctor->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            @if($queue->status == 'waiting')
              <span class="text-yellow-600 font-medium">Menunggu</span>
            @elseif($queue->status == 'called')
              <span class="text-blue-600 font-medium">Dipanggil</span>
            @else
              <span class="text-green-600 font-medium">Selesai</span>
            @endif
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ \Carbon\Carbon::parse($queue->registration_time)->timezone('Asia/Jakarta')->format('H:i') }}
          </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
            <div class="flex space-x-2">
                @if($queue->status == 'waiting')
                    <form method="POST" action="{{ route('queues.call-next') }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Panggil antrian ini?')" class="text-blue-600 hover:text-blue-800">Panggil</button>
                    </form>
                    <form method="POST" action="{{ route('queues.complete', $queue->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Selesaikan antrian ini?')" class="text-green-600 hover:text-green-800">Selesaikan</button>
                    </form>
                @elseif($queue->status == 'called')
                    <form method="POST" action="{{ route('queues.complete', $queue->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Selesaikan antrian ini?')" class="text-green-600 hover:text-green-800">Selesaikan</button>
                    </form>
                @else
                    <span class="text-gray-500 italic">Selesai</span>
                @endif
            </div>
        </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Belum ada antrian untuk hari ini.
                Debug: Poli ID {{ Auth::user()->poli_id }},
                Tanggal: {{ now()->timezone('Asia/Jakarta')->format('Y-m-d') }}
            </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

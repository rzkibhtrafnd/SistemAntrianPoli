@extends('layouts.app')

@section('title', 'Dashboard Antrian')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 md:p-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Antrian</h1>
                <p class="text-gray-600">Monitor antrian pasien secara real-time</p>
            </div>
            <div class="mt-4 md:mt-0 bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="text-right mr-3">
                        <p class="text-xs text-gray-500">Waktu Jakarta</p>
                        <p id="current-time" class="text-lg font-semibold">
                            {{ now()->timezone('Asia/Jakarta')->format('H:i:s') }}
                        </p>
                        <p id="current-date" class="text-sm">
                            {{ now()->timezone('Asia/Jakarta')->format('d F Y') }}
                        </p>
                    </div>
                    <i class="fas fa-clock text-3xl text-blue-500"></i>
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @php
                $totalPatients = $queues->count();
                $waitingCount = $queues->where('status', 'waiting')->count();
                $calledCount = $queues->where('status', 'called')->count();
                $completedCount = $queues->where('status', 'completed')->count();
            @endphp

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pasien Hari Ini</p>
                        <p id="total-patients" class="text-2xl font-bold">{{ $totalPatients }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Menunggu</p>
                        <p id="waiting-count" class="text-2xl font-bold">{{ $waitingCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dipanggil</p>
                        <p id="called-count" class="text-2xl font-bold">{{ $calledCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Selesai</p>
                        <p id="completed-count" class="text-2xl font-bold">{{ $completedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sedang Dipanggil --}}
        @php
            $currentCall = $queues->where('status', 'called')->sortByDesc('called_time')->first();
        @endphp
        @if($currentCall)
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Sedang Dipanggil</h2>
                </div>
                <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-500">Nomor Antrian</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $currentCall->queue_number }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-500">Nama Pasien</p>
                        <p class="text-2xl font-semibold">{{ $currentCall->patient->name ?? '-' }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-500">Poli</p>
                        <p class="text-xl">{{ $currentCall->poli->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Status Antrian per Poli --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($polis as $poli)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-blue-600">{{ $poli['name'] }}</h3>

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Antrian Sekarang</p>
                        <p class="text-3xl font-bold">{{ $poli['current_queue'] ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Pasien</p>
                        <p class="text-lg">{{ $poli['current_patient'] ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Menunggu</span>
                        <span class="font-medium">{{ $poli['waiting_count'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Selesai</span>
                        <span class="font-medium">{{ $poli['completed_count'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Audio --}}
<audio id="announcement-sound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>
<audio id="call-sound" src="{{ asset('sounds/call.mp3') }}" preload="auto"></audio>
@endsection

@push('scripts')
<script>
let isFirstLoad = true;
let lastUpdateTime = null;

function fetchQueueData() {
    fetch('/dashboard/queue-status?t=' + new Date().getTime()) // Tambahkan cache buster
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            let currentCall = null;
            let hasChanges = false;

            data.forEach(poli => {
                const id = poli.id;
                const waitingCount = poli.waiting_count;
                const completedCount = poli.completed_count;

                // Periksa apakah data berbeda dengan yang ditampilkan
                const currentDisplayed = {
                    queue: document.getElementById(`current-queue-${id}`).textContent,
                    waiting: document.getElementById(`waiting-${id}`).textContent,
                    completed: document.getElementById(`completed-${id}`).textContent
                };

                if (currentDisplayed.queue !== (poli.current_queue || '-') ||
                    currentDisplayed.waiting != waitingCount ||
                    currentDisplayed.completed != completedCount) {
                    hasChanges = true;
                }

                // Update UI
                document.getElementById(`current-queue-${id}`).textContent = poli.current_queue || '-';
                document.getElementById(`waiting-${id}`).textContent = waitingCount;
                document.getElementById(`completed-${id}`).textContent = completedCount;

                if (poli.current_queue && (isFirstLoad || lastCalledNumber !== poli.current_queue)) {
                    currentCall = poli;
                }
            });

            if (hasChanges || isFirstLoad) {
                updateGlobalStats(data);

                if (currentCall) {
                    updateCurrentCall(currentCall);
                    lastCalledNumber = currentCall.current_queue;
                }
            }

            isFirstLoad = false;
        })
        .catch(error => {
            console.error('Error fetching queue data:', error);
            // Coba lagi lebih cepat jika error
            setTimeout(fetchQueueData, 1000);
        });
}

function updateGlobalStats(data) {
    const totalWaiting = data.reduce((sum, poli) => sum + poli.waiting_count, 0);
    const totalCompleted = data.reduce((sum, poli) => sum + poli.completed_count, 0);
    const totalCalled = data.filter(poli => poli.current_queue).length;

    document.getElementById('waiting-count').textContent = totalWaiting;
    document.getElementById('completed-count').textContent = totalCompleted;
    document.getElementById('called-count').textContent = totalCalled;
    document.getElementById('total-patients').textContent = totalWaiting + totalCompleted + totalCalled;
}

function updateCurrentCall(currentCall) {
    const callContainer = document.getElementById('current-call-container');
    callContainer.classList.remove('hidden');
    document.getElementById('current-call-number').textContent = currentCall.current_queue;
    document.getElementById('current-call-patient').textContent = currentCall.current_patient;
    document.getElementById('current-call-poli').textContent = currentCall.name;

    // Hanya play sound jika bukan first load
    if (!isFirstLoad) {
        playCallSound();
        speakAnnouncement(`Nomor antrian ${currentCall.current_queue}, atas nama ${currentCall.current_patient}, silakan menuju ${currentCall.name}`);
    }
}

// Ubah interval menjadi 3 detik
setInterval(fetchQueueData, 3000);
fetchQueueData();
</script>
@endpush

@extends('layouts.app')

@section('title', 'Dashboard Antrian')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6 md:p-12">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900">Dashboard Antrian</h1>
                <p class="mt-1 text-lg text-gray-600">Pantau antrian pasien secara real-time</p>
            </div>
            <div class="mt-5 md:mt-0 bg-white rounded-xl shadow-lg px-6 py-4 flex items-center gap-5">
                <div class="text-right">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Waktu</p>
                    <p id="current-time" class="text-2xl font-semibold text-indigo-600">{{ now()->format('H:i:s') }}</p>
                    <p id="current-date" class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <i class="fas fa-clock text-indigo-400 text-4xl"></i>
            </div>
        </header>

        {{-- Statistik --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
                <div class="p-4 rounded-full bg-indigo-100 text-indigo-700">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-400">Total Pasien Hari Ini</p>
                    <p id="total-patients" class="text-3xl font-extrabold text-gray-900">{{ $initialData['global_stats']['total_patients'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
                <div class="p-4 rounded-full bg-yellow-100 text-yellow-700">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-400">Menunggu</p>
                    <p id="waiting-count" class="text-3xl font-extrabold text-gray-900">{{ $initialData['global_stats']['waiting_count'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
                <div class="p-4 rounded-full bg-blue-100 text-blue-700">
                    <i class="fas fa-bullhorn text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-400">Dipanggil</p>
                    <p id="called-count" class="text-3xl font-extrabold text-gray-900">{{ $initialData['global_stats']['called_count'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
                <div class="p-4 rounded-full bg-green-100 text-green-700">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-400">Selesai</p>
                    <p id="completed-count" class="text-3xl font-extrabold text-gray-900">{{ $initialData['global_stats']['completed_count'] }}</p>
                </div>
            </div>
        </section>

        {{-- Sedang Dipanggil --}}
        <section id="current-call-section" class="mb-12">
            @if($initialData['global_current_call'])
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-300">
                <div class="bg-indigo-600 px-8 py-5">
                    <h2 class="text-2xl font-bold text-white tracking-wide">Sedang Dipanggil</h2>
                </div>
                <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="text-center md:text-left">
                        <p class="uppercase text-gray-400 text-sm tracking-wide">Nomor Antrian</p>
                        <p class="text-6xl font-extrabold text-indigo-700 leading-tight">{{ $initialData['global_current_call']['queue_number'] }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="uppercase text-gray-400 text-sm tracking-wide">Nama Pasien</p>
                        <p class="text-3xl font-semibold text-gray-900">{{ $initialData['global_current_call']['patient_name'] }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="uppercase text-gray-400 text-sm tracking-wide">Poli</p>
                        <p class="text-2xl text-indigo-600 font-semibold">{{ $initialData['global_current_call']['poli_name'] }}</p>
                    </div>
                </div>
            </div>
            @endif
        </section>

        {{-- Status Antrian per Poli --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($initialData['polis'] as $poli)
            <div class="bg-white rounded-xl shadow-lg p-8 border border-indigo-200 hover:shadow-xl transition-shadow">
                <h3 class="text-2xl font-bold mb-6 text-indigo-600">{{ $poli['name'] }}</h3>

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="uppercase text-gray-400 text-sm tracking-wide">Antrian Sekarang</p>
                        <p id="current-queue-{{ $poli['id'] }}" class="text-4xl font-extrabold text-gray-900">{{ $poli['current_queue'] ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="uppercase text-gray-400 text-sm tracking-wide">Pasien</p>
                        <p class="text-xl font-semibold text-gray-700">{{ $poli['current_patient'] ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-3 text-gray-600 text-base">
                    <div class="flex justify-between">
                        <span>Menunggu</span>
                        <span id="waiting-{{ $poli['id'] }}" class="font-semibold text-gray-800">{{ $poli['waiting_count'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Selesai</span>
                        <span id="completed-{{ $poli['id'] }}" class="font-semibold text-gray-800">{{ $poli['completed_count'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </div>
</div>

<audio id="call-sound" src="{{ asset('sounds/call.mp3') }}" preload="auto"></audio>
<audio id="notification-sound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>
@endsection

@push('scripts')
<script>
    // Update waktu real-time
    function updateClock() {
        const now = new Date();
        document.getElementById('current-time').textContent =
            now.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit', second:'2-digit'});
        document.getElementById('current-date').textContent =
            now.toLocaleDateString('id-ID', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'});
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Real-time queue updates
    let lastUpdateTime = null;
    let lastCalledQueue = null;

    function fetchQueueData() {
        fetch('/dashboard/queue-status?t=' + new Date().getTime())
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                // Update global stats
                document.getElementById('total-patients').textContent = data.global_stats.total_patients;
                document.getElementById('waiting-count').textContent = data.global_stats.waiting_count;
                document.getElementById('called-count').textContent = data.global_stats.called_count;
                document.getElementById('completed-count').textContent = data.global_stats.completed_count;

                // Update per poli
                data.polis.forEach(poli => {
                    document.getElementById(`current-queue-${poli.id}`).textContent = poli.current_queue || '-';
                    document.getElementById(`waiting-${poli.id}`).textContent = poli.waiting_count;
                    document.getElementById(`completed-${poli.id}`).textContent = poli.completed_count;
                });

                // Update current call section
                updateCurrentCall(data.global_current_call);
            })
            .catch(error => {
                console.error('Error fetching queue data:', error);
                setTimeout(fetchQueueData, 5000); // Retry after 5 seconds on error
            });
    }

    function updateCurrentCall(currentCall) {
        const section = document.getElementById('current-call-section');

        if (!currentCall) {
            section.innerHTML = '';
            return;
        }

        // Check if this is a new call
        if (lastCalledQueue !== currentCall.queue_number) {
            lastCalledQueue = currentCall.queue_number;
            document.getElementById('call-sound').play();

            const html = `
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-300 animate-pulse">
                    <div class="bg-indigo-600 px-8 py-5">
                        <h2 class="text-2xl font-bold text-white tracking-wide">Sedang Dipanggil</h2>
                    </div>
                    <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-12">
                        <div class="text-center md:text-left">
                            <p class="uppercase text-gray-400 text-sm tracking-wide">Nomor Antrian</p>
                            <p class="text-6xl font-extrabold text-indigo-700 leading-tight">${currentCall.queue_number}</p>
                        </div>
                        <div class="text-center md:text-left">
                            <p class="uppercase text-gray-400 text-sm tracking-wide">Nama Pasien</p>
                            <p class="text-3xl font-semibold text-gray-900">${currentCall.patient_name}</p>
                        </div>
                        <div class="text-center md:text-left">
                            <p class="uppercase text-gray-400 text-sm tracking-wide">Poli</p>
                            <p class="text-2xl text-indigo-600 font-semibold">${currentCall.poli_name}</p>
                        </div>
                    </div>
                </div>
            `;

            section.innerHTML = html;

            // Remove animation after 2 seconds
            setTimeout(() => {
                const element = section.querySelector('.animate-pulse');
                if (element) {
                    element.classList.remove('animate-pulse');
                }
            }, 2000);
        }
    }

    // Fetch data every 2 seconds
    setInterval(fetchQueueData, 2000);
    fetchQueueData(); // Initial load
</script>
@endpush

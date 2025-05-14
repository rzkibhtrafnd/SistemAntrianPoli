<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') - {{ config('app.name', 'Rumah Sakit') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Flowbite -->
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.7.0/dist/flowbite.min.css" />
  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Poppins', 'sans-serif'] }
        }
      }
    }
  </script>
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6 flex items-center space-x-3">
        <div class="bg-blue-600 text-white p-2 rounded-lg">
          <i data-feather="activity"></i>
        </div>
        <h1 class="text-xl font-semibold text-gray-800">RS. Sehat Sentosa</h1>
      </div>
      <ul class="space-y-2 px-4">
        <li>
          <a href="{{ route('queues.by-poli') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('queues.by-poli') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
            <i data-feather="list" class="w-5 h-5 mr-3"></i> Antrian Poli
          </a>
        </li>
                <li class="pt-4 border-t border-gray-200 mt-4">
            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-600 transition">
                <i data-feather="log-out" class="w-5 h-5 mr-3"></i> Logout
            </button>
            </form>
        </li>
      </ul>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Navbar -->
      <nav class="bg-white shadow flex items-center justify-between px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-800">@yield('title')</h2>
        <div class="flex items-center space-x-4">
          <button class="relative p-2 hover:bg-gray-100 rounded-full">
            <i data-feather="bell" class="w-6 h-6 text-gray-600"></i>
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center space-x-2">
            <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center uppercase">{{ substr(auth()->user()->name,0,1) }}</div>
            <span class="text-gray-700">{{ auth()->user()->name }}</span>
          </div>
        </div>
      </nav>

      <!-- Content -->
      <main class="flex-1 overflow-auto p-6">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace()</script>
</body>
</html>

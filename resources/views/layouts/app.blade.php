<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>RoseReads</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Rubik+Maze&display=swap" rel="stylesheet">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x" defer></script>

</head>

<body class="bg-gray-100 font-sans" style="font-family: 'Poppins', sans-serif;">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-pink-400 to-pink-600 text-white flex flex-col shadow-lg">
        <div class="p-6 flex flex-col items-center border-b border-pink-300">
            <!-- Sidebar Title -->
            <div class="text-2xl md:text-3xl font-bold" style="font-family: 'Rubik Maze', sans-serif;">
                RoseReads
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" 
               class="block py-2 px-4 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard') ? 'bg-white text-pink-600 font-semibold shadow' : 'hover:bg-pink-500 hover:text-white' }}">
                Dashboard
            </a>

            <a href="{{ route('books.index') }}" 
               class="block py-2 px-4 rounded-lg transition-colors duration-200
               {{ request()->routeIs('books.*') ? 'bg-white text-pink-600 font-semibold shadow' : 'hover:bg-pink-500 hover:text-white' }}">
                Books
            </a>

            <a href="{{ route('categories.index') }}" 
               class="block py-2 px-4 rounded-lg transition-colors duration-200
               {{ request()->routeIs('categories.*') ? 'bg-white text-pink-600 font-semibold shadow' : 'hover:bg-pink-500 hover:text-white' }}">
                Categories
            </a>
        </nav>

        <!-- User & Logout -->
        <div class="p-4 border-t border-pink-300 mt-auto">
            <div class="text-sm font-medium mb-2">{{ auth()->user()->name ?? 'User' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full py-2 px-4 rounded-lg bg-pink-700 hover:bg-pink-800 transition text-white font-semibold text-sm">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 bg-gray-50">
        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-pink-100 border-l-4 border-pink-500 text-pink-700 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Content -->
        <div class="bg-white rounded-xl shadow-md p-6">
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Library Catalog') }}</title>
    
    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-50 text-slate-800 font-sans antialiased flex flex-col">

    <!-- Top Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2.5 transition opacity-90 hover:opacity-100">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-sm shadow-blue-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="font-bold text-lg text-slate-900 tracking-tight">{{ config('app.name', 'Library System') }}</span>
            </a>

            <div>
                <a href="{{route('kiosk.index')}}">
                    Enter
                </a>
            </div>

            <!-- Auth Navigation -->
            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition px-3 py-2 rounded-lg hover:bg-slate-100">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition px-3 py-2 rounded-lg hover:bg-slate-100">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition px-4 py-2 rounded-lg shadow-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        
        <!-- Hero Section -->
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 text-white p-8 sm:p-10 shadow-xl border border-slate-800">
            <div class="relative z-10 max-w-2xl space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-300 border border-blue-500/20">
                    Public Library Access
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    Explore our collection of titles and authors.
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Browse active inventory levels, author details, and new arrivals straight from our catalog database.
                </p>
            </div>
            
            <!-- Subtle background decorative element -->
            <div class="absolute -right-12 -bottom-12 opacity-10 pointer-events-none">
                <svg class="w-80 h-80 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </section>

        <!-- Key Metrics Section -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Metric 1 -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Available Books</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">
                        {{ $availableBooksCount ?? 0 }}
                    </p>
                </div>
                <div class="w-11 h-11 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>

            <!-- Metric 2 -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Authors</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">
                        {{ $authorsCount ?? 0 }}
                    </p>
                </div>
                <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
            </div>

            <!-- Metric 3 -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Categories</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">
                        {{ $categoriesCount ?? 0 }}
                    </p>
                </div>
                <div class="w-11 h-11 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
        </section>

        <!-- Book Gallery -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Newest Additions</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @forelse($latestBooks ?? [] as $book)
                    <article class="group bg-white rounded-xl border border-slate-200/80 p-3.5 flex flex-col transition duration-200 hover:shadow-lg hover:-translate-y-0.5">
                        
                        <!-- Book Cover Container -->
                        <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-lg overflow-hidden mb-3 border border-slate-100">
                            @if($book->image)
                                <img 
                                    src="{{ asset('storage/' . $book->image) }}" 
                                    alt="{{ $book->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                    loading="lazy"
                                >
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                    <svg class="w-8 h-8 mb-1 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs italic">No image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content Details -->
                        <div class="flex flex-col flex-1 justify-between space-y-2">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm line-clamp-1 group-hover:text-blue-600 transition">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $book->author?->name ?? 'Unknown Author' }}
                                </p>
                            </div>

                            <div class="pt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold uppercase tracking-wider
                                    {{ $book->status === 'available' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-600 border border-slate-200/60' }}">
                                    {{ $book->status }}
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-xl border border-dashed border-slate-200 p-6">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-slate-500 font-medium text-sm">No books found in the catalog.</p>
                        <p class="text-slate-400 text-xs mt-1">Check back later for new arrivals.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Library System') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
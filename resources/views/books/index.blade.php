<x-app-layout>
<div class="bg-amber-50/20 min-h-screen font-sans pb-12">
    <!-- Header Navigation -->
    <header class="bg-red-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider text-amber-300">ISKO-LIB</h1>
            <nav class="flex items-center space-x-6 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="hover:text-amber-200 transition">Home</a>
                <a href="{{ route('books.index') }}" class="text-amber-300 border-b-2 border-amber-300 pb-0.5">Books</a>
            </nav>
            <div class="flex items-center space-x-3">
                <span class="text-lg">👤</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold px-4 py-1.5 rounded-md text-xs transition shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Column: Borrow Form Action & History -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Borrow Form Banner Card -->
                <div class="bg-white rounded-2xl border-2 border-red-900 p-6 shadow-md text-center space-y-3">
                    <h3 class="text-xl font-black text-red-900 tracking-wide uppercase">BORROW FORM</h3>
                    <p class="text-slate-600 text-xs leading-relaxed text-justify">
                        Access the library's collection through a simplified borrowing system designed to facilitate student, instructional and research activities. Library users are welcomed to discover the resources on shelf and use the lending services in an efficient way complying with the rules of the library.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('borrow.create') }}" 
                        class="inline-block bg-amber-400 hover:bg-amber-500 text-slate-900 font-extrabold text-xs px-8 py-2.5 rounded-md shadow border border-amber-500 transition">
                            CLICK ME
                        </a>
                    </div>
                </div>

                <!-- Book History Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-red-900">Book History</h3>
                    <div class="space-y-3">
                        @forelse($historyBooks ?? [] as $item)
                            <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                                <div class="flex items-center space-x-3 min-w-0">
                                    <!-- Book Thumbnail with Fallback -->
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                        @if($item->book?->image)
                                            <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-base">📖</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 line-clamp-1">{{ $item->book?->title }}</p>
                                        <p class="text-[10px] text-slate-500 line-clamp-1">{{ $item->book?->author?->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono ml-2 flex-shrink-0">
                                    {{ $item->created_at ? $item->created_at->format('m/d/y') : '' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs italic text-center py-2">No past history recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Categorized Lists -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Section 1: Borrow Requests -->
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-red-900">Borrow Requests</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($requests ?? [] as $request)
                            <div class="bg-white rounded-xl border border-slate-200 p-2.5 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $request->status === 'Approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-mono">
                                            {{ $request->created_at ? $request->created_at->format('m/d/y') : '' }}
                                        </span>
                                    </div>
                                    
                                    <!-- Book Image with Fallback -->
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 border border-slate-100 flex items-center justify-center">
                                        @if($request->book?->image)
                                            <img src="{{ asset('storage/' . $request->book->image) }}" alt="{{ $request->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>

                                    <p class="text-[9px] font-mono text-slate-400 truncate">{{ $request->book?->isbn }}</p>
                                    <h4 class="font-bold text-slate-800 text-xs line-clamp-1">{{ $request->book?->title }}</h4>
                                    <p class="text-[10px] text-slate-500 line-clamp-1">{{ $request->book?->author?->name ?? 'Unknown Author' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $request->book_id) }}" class="mt-2 block text-center bg-amber-400 text-slate-900 font-bold text-[10px] py-1 rounded-md hover:bg-amber-500 transition">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 2: Unborrowed Books -->
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-red-900">Unborrowed Books</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($unborrowedBooks ?? [] as $book)
                            <div class="bg-white rounded-xl border border-slate-200 p-2.5 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Unborrowed</span>
                                        <span class="text-[9px] text-slate-400 font-mono">
                                            {{ $book->created_at ? $book->created_at->format('m/d/y') : '01/23/26' }}
                                        </span>
                                    </div>

                                    <!-- Book Image with Fallback -->
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 border border-slate-100 flex items-center justify-center">
                                        @if($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>

                                    <p class="text-[9px] font-mono text-slate-400 truncate">{{ $book->isbn }}</p>
                                    <h4 class="font-bold text-slate-800 text-xs line-clamp-1">{{ $book->title }}</h4>
                                    <p class="text-[10px] text-slate-500 line-clamp-1">{{ $book->author?->name ?? 'Unknown Author' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $book->id) }}" class="mt-2 block text-center bg-amber-400 text-slate-900 font-bold text-[10px] py-1 rounded-md hover:bg-amber-500 transition">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 3: Borrowed Books -->
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-red-900">Borrowed Books</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($borrowedBooksList ?? [] as $borrowed)
                            <div class="bg-white rounded-xl border border-slate-200 p-2.5 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800">Borrowed</span>
                                        <span class="text-[9px] text-slate-400 font-mono">
                                            {{ $borrowed->borrowed_at ? $borrowed->borrowed_at->format('m/d/y') : '' }}
                                        </span>
                                    </div>

                                    <!-- Book Image with Fallback -->
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 border border-slate-100 flex items-center justify-center">
                                        @if($borrowed->book?->image)
                                            <img src="{{ asset('storage/' . $borrowed->book->image) }}" alt="{{ $borrowed->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>

                                    <p class="text-[9px] font-mono text-slate-400 truncate">{{ $borrowed->book?->isbn }}</p>
                                    <h4 class="font-bold text-slate-800 text-xs line-clamp-1">{{ $borrowed->book?->title }}</h4>
                                    <p class="text-[10px] text-slate-500 line-clamp-1">{{ $borrowed->book?->author?->name ?? 'Unknown Author' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $borrowed->book_id) }}" class="mt-2 block text-center bg-amber-400 text-slate-900 font-bold text-[10px] py-1 rounded-md hover:bg-amber-500 transition">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
</x-app-layout>
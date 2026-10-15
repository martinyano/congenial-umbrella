<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Column: Borrow Form Action & History -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Borrow Form Card -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm text-center space-y-3">
                    <h3 class="text-lg font-bold text-slate-800 tracking-wide uppercase">Borrow Form</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Access the library's collection through our simplified borrowing system. Discover resources on shelves and use lending services efficiently.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('borrow.create') }}" 
                           class="inline-block bg-red-900 hover:bg-red-800 text-white font-semibold text-xs px-6 py-2 rounded-lg transition shadow-sm">
                            Click to Borrow
                        </a>
                    </div>
                </div>

                <!-- Book History Card -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm space-y-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Book History</h3>
                    <div class="space-y-2">
                        @forelse($historyBooks ?? [] as $item)
                            <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg border border-slate-100 text-xs">
                                <div class="flex items-center space-x-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded bg-slate-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                        @if($item->book?->image)
                                            <img src="{{ asset('storage/' . $item->book->image) }}" alt="" class="w-full h-full object-contain">
                                        @else
                                            <span>📖</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate">{{ $item->book?->title }}</p>
                                        <p class="text-[10px] text-slate-400 truncate">{{ $item->book?->author?->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono ml-2 flex-shrink-0">
                                    {{ $item->created_at?->format('m/d/y') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs italic text-center py-2">No history recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Categorized Lists -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Section 1: Borrow Requests -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Borrow Requests</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @forelse($requests ?? [] as $request)
                            <div class="bg-white rounded-xl border border-slate-200 p-3 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-100 text-amber-800">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-mono">{{ $request->created_at?->format('m/d/y') }}</span>
                                    </div>
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 flex items-center justify-center">
                                        @if($request->book?->image)
                                            <img src="{{ asset('storage/' . $request->book->image) }}" alt="" class="w-full h-full object-contain">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-slate-800 text-xs truncate">{{ $request->book?->title }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $request->book?->author?->name ?? 'Unknown' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $request->book_id) }}" class="mt-3 block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[10px] py-1.5 rounded transition">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-4 text-center text-slate-400 text-xs italic">No pending requests.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 2: Unborrowed Books -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Unborrowed Books</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @forelse($unborrowedBooks ?? [] as $book)
                            <div class="bg-white rounded-xl border border-slate-200 p-3 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">Unborrowed</span>
                                        <span class="text-[9px] text-slate-400 font-mono">{{ $book->created_at?->format('m/d/y') }}</span>
                                    </div>
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 flex items-center justify-center">
                                        @if($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="" class="w-full h-full object-contain">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-slate-800 text-xs truncate">{{ $book->title }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $book->author?->name ?? 'Unknown' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $book->id) }}" class="mt-3 block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[10px] py-1.5 rounded transition">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-4 text-center text-slate-400 text-xs italic">No unborrowed books found.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 3: Borrowed Books -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Borrowed Books</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @forelse($borrowedBooksList ?? [] as $borrowed)
                            <div class="bg-white rounded-xl border border-slate-200 p-3 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700">Borrowed</span>
                                        <span class="text-[9px] text-slate-400 font-mono">{{ $borrowed->borrowed_at?->format('m/d/y') }}</span>
                                    </div>
                                    <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-2 flex items-center justify-center">
                                        @if($borrowed->book?->image)
                                            <img src="{{ asset('storage/' . $borrowed->book->image) }}" alt="" class="w-full h-full object-contain">
                                        @else
                                            <span class="text-2xl">📖</span>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-slate-800 text-xs truncate">{{ $borrowed->book?->title }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $borrowed->book?->author?->name ?? 'Unknown' }}</p>
                                </div>
                                <a href="{{ route('books.public_show', $borrowed->book_id) }}" class="mt-3 block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[10px] py-1.5 rounded transition">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-4 text-center text-slate-400 text-xs italic">No active borrowed books.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
<div class="bg-slate-50 min-h-screen text-slate-800 antialiased p-4 md:p-8">
    <main class="max-w-7xl mx-auto space-y-6">
        
        <!-- Streamlined Greeting -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex justify-between items-center gap-4">
            <div class="space-y-1">
                <h2 class="text-xl font-bold text-red-900">Greetings, Student!</h2>
                <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                    Explore, evaluate, and utilize our information resources independently to extend your learning and research work.
                </p>
            </div>
            <span class="text-4xl hidden sm:inline">📚</span>
        </div>

        <!-- Auto-Flowing Category Filters -->
        <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
            <a href="{{ route('dashboard') }}" 
               class="px-3 py-1 rounded-full text-xs font-medium border transition {{ !request('category') ? 'bg-red-900 text-white border-red-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                All Categories
            </a>

            @foreach($categories ?? [] as $category)
                <a href="{{ route('dashboard', ['category' => $category->id]) }}" 
                   class="px-3 py-1 rounded-full text-xs font-medium border transition {{ request('category') == $category->id ? 'bg-red-900 text-white border-red-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Fully Responsive Grid (Auto-sizing from mobile to desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($books ?? [] as $book)
                <div class="bg-white rounded-xl border border-slate-200 p-3 flex flex-col justify-between hover:shadow-sm transition">
                    <div>
                        <div class="flex justify-between text-[10px] font-bold text-slate-400 mb-2">
                            <span class="text-emerald-600 uppercase">{{ $book->status ?? 'Available' }}</span>
                            <span>QTY: {{ $book->quantity ?? 1 }}</span>
                        </div>

                        <!-- Book Image Context -->
                        <div class="aspect-square bg-slate-50 rounded-lg overflow-hidden flex items-center justify-center border border-slate-100 mb-2">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-contain">
                            @else
                                <span class="text-2xl">📖</span>
                            @endif
                        </div>

                        <div class="text-left text-[11px]">
                            <p class="font-mono text-slate-400 truncate">{{ $book->isbn ?? '978-000000000' }}</p>
                            <h4 class="font-bold text-slate-800 line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</h4>
                            <p class="text-slate-500 line-clamp-1">{{ $book->author?->name ?? 'Unknown Author' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('books.public_show', $book->id) }}" 
                       class="block w-full text-center bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-[11px] py-1.5 rounded-md transition mt-3">
                        View Details
                    </a>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No books found under this category.
                </div>
            @endforelse
        </div>
    </main>
</div>
</x-app-layout>

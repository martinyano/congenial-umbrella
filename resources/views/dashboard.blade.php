<x-app-layout>

    <div class="bg-amber-50/20 min-h-screen font-sans pb-12">
    <!-- Header Navigation -->
    <header class="bg-red-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider text-amber-300">ISKO-LIB</h1>
            
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-6">
        <!-- Greetings Banner -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between shadow-sm">
            <div class="max-w-2xl space-y-2">
                <h2 class="text-2xl font-bold text-red-900">Greetings, Student!</h2>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                    Greetings from the library! This academic institution acts as a research and study hub, allowing users to engage intellectually through access to materials that support what you need. Students are motivated to independently explore, evaluate, and utilize information resources in order to extend their learning and research work.
                </p>
            </div>
            <div class="mt-4 md:mt-0 text-6xl">
                📚🎓
            </div>
        </div>

        <!-- Dynamic Category Filters from Database -->
        <div class="flex flex-wrap gap-2 sm:gap-3 justify-center md:justify-start">
            <!-- 'All' Filter Button -->
            <a href="{{ route('dashboard') }}" 
            class="px-4 py-1.5 font-semibold rounded-full text-xs shadow-sm border transition {{ !request('category') ? 'bg-red-900 text-white border-red-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                All Categories
            </a>

            <!-- Loop Through Real Categories from Database -->
            @foreach($categories ?? [] as $category)
                <a href="{{ route('dashboard', ['category' => $category->id]) }}" 
                class="px-4 py-1.5 font-semibold rounded-full text-xs shadow-sm border transition {{ request('category') == $category->id ? 'bg-red-900 text-white border-red-900' : 'bg-red-50 text-red-800 border-red-200 hover:bg-red-100' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Catalog Books Grid -->
                <!-- Catalog Books Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($books ?? [] as $book)
                <div class="bg-white rounded-xl border border-slate-200 p-3 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                    <div>
                        <!-- Header Badges -->
                        <div class="flex justify-between items-center mb-2">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                                {{ $book->status ?? 'Available' }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500">
                                QTY: {{ $book->quantity ?? 1 }}
                            </span>
                        </div>

                        <!-- Book Image / Thumbnail -->
                        <div class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden mb-3 flex items-center justify-center border border-slate-100">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">📖</span>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div class="space-y-0.5 text-left">
                            <p class="text-[10px] font-mono text-slate-400 truncate">{{ $book->isbn ?? '978-000000000' }}</p>
                            <h4 class="font-bold text-slate-800 text-xs line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</h4>
                            <p class="text-[10px] text-slate-500 line-clamp-1">{{ $book->author?->name ?? 'Unknown Author' }}</p>
                        </div>
                    </div>

                    <!-- View Details Action -->
                    <div class="mt-3">
                        <a href="{{ route('books.public_show', $book->id) }}" 
                        class="block w-full text-center bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-[11px] py-1 rounded-md shadow-sm transition">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-sm">
                    No books found under this category.
                </div>
            @endforelse
        </div>
    </main>
</div>
</x-app-layout>

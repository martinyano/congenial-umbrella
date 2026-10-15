<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Header section with Title and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <!-- FIXED: Changed 'Show Author' to 'Show Book' to match the content -->
                    <h4 class="text-xl font-bold text-gray-900">Show Book Details</h4>
                    <a href="{{ url('books') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Back
                    </a>
                </div>

                <!-- Book Information Display -->
                <div class="space-y-4">

                        <div>
                            <label class="block font-bold text-gray-700">Cover Image</label>
                            @if($book->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="max-w-xs h-auto rounded shadow-md border">
                                </div>
                            @else
                                <p class="text-gray-500 italic mt-1">No image uploaded</p>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">Title</label>
                            <p class="text-gray-900 text-lg">{{ $book->title }}</p>
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">Author</label>
                            <!-- FIXED: Now safely prints the actual author's name instead of form selection logic -->
                            <p class="text-gray-900">{{ $book->author?->name ?? 'No Author Assigned' }}</p>
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">ISBN</label>
                            <p class="text-gray-900 font-mono">{{ $book->isbn }}</p>
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">Quantity</label>
                            <p class="text-gray-900">{{ $book->quantity }} copies</p>
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">Category</label>
                            <!-- FIXED: Now safely prints the actual category name -->
                            <p class="text-gray-900">{{ $book->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        
                        <div>
                            <label class="block font-bold text-gray-700">Status</label>
                            <p class="mt-1">
                                <!-- Earlier you set up status strings ('available', 'borrowed', 'lost'). Let's show it cleanly: -->
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $book->status }}
                                </span>
                            </p>
                        </div>
                        
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

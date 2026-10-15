<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Header section with Title and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-900">Edit Category</h4>
                    <a href="{{ url('categories') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Back
                    </a>
                </div>

                <!-- Styled Tailwind Responsive Table -->
                <div class="overflow-x-auto">
                    <form action="{{route('admin.categories.update', $category->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="">Name</label>
                            <input type="text" name="name" value="{{$category->name}}">
                            @error('name')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="">Description</label>
                            <textarea type="text" name="description">{{!! $category->description !!}}</textarea>
                            @error('description')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <label for="">Status</label>
                            <input type="checkbox" name="status" {{$category->status == 1 ? 'Active':''}} checked> checked=visible unchecked=not visible
                            @error('status')
                                {{$message}}
                            @enderror
                        </div>
                        <div>
                            <button type="submit">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

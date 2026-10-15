<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Header section with Title and Add Button -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-900">Show Users</h4>
                    <a href="{{ url('users') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Back
                    </a>
                </div>

                <!-- Styled Tailwind Responsive Table -->
                <div class="overflow-x-auto">
                
                        <div>
                            <label for="">Name</label>
                            <p>{{$user->name}}</p>
                        </div>
                        <div>
                            <label for="">RFID</label>
                            <p>{{!! $user->rfid_uid !!}}</p>
                        </div>
                        <div>
                            <label for="">Email</label>
                            <p>{{$user->email}}</p>
                        </div>
                        <div>
                            <label for="">Status</label>
                            <p>{{$user->status == 1 ? 'Active':''}}</p>
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

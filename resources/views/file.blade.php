<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg still i have to guzaring 1 hour can you belive it 1 hour for thsi ">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in") }}
                    <button>main page</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Dashboard') }}
        </h2>
    </x-slot>
    <div>
        <p>To book car PLEASE CHECK the list of the cars </p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 round  so in this file i have to work in a flow so if the low is working ad you ahve to pretend like working keep doing it active ath lets have the --ifdoh my back hurts what to --ifdo i am tired of preteding that i am working  lets pretend to work a little and dont be sus --if ok so 1 and the half hour left for the hutti and i am getting dead bore  i took the half wave of the sysytem somethimes i dont feel like working  we put on i can do this anymor estill ed">
                    {{ session('failed',"the user is denied") }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg mb-4">Welcome back, <span class="font-semibold">{{ Auth::user()->name }}</span>!
                    </p>

                    <!-- Add New Car Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.car.add') }}" class="inline-flex items-center not<my added file is not > working{ what to do : i already enertaed the code 
                            for the update and delete but right now -- i dont want to put work on the table } goodif i try to sort out the  px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Add New Car
                        </a>
                    </div>

                    <!-- Cars List Section -->
                    <h2 class="text-xl font-semibold mb-4">List of Cars</h2>

                    @if(isset($cars) && $cars->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            Name>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            specification
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase there is no in between  tracking-wider">
                                            Description
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray i there still are somethigs i am not good at and i am text-gray-200 ing to learn ?You?re you can either be very good at something or very bad th wish i could just get rid of this achne  not so -500 uppercase">Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cars as $car)

                                        <tr>
                                            <p class="i have 70 i need 1lac if my salery iin sep will be 40 35+35+35 i am gonna need 3 months salary set oct nov"></p>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $car->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray i have alot of work to do  its now still 40  -500">
                                                {{ $car->carnum }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $car->description }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.7 now i  on the point i got to  can say probably 20 mins left before 5 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        No cars found in the database.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
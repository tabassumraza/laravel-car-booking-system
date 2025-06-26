<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg mb-4">Welcome back, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Available Cars Section -->
                    <h2 class="text-xl font-semibold mb-4">Available Cars</h2>

                    @if($availableCars->count() > 0)
                        <div class="overflow-x-auto mb-8">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Car Number
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Booking Type
                                        </th>
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Availability
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($availableCars as $car)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $car->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $car->carnum }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $car->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Daily Booking Button -->
                                                    <form action="{{ route('user.bookings.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                                                        <input type="hidden" name="booking_type" value="daily">
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900 px-3 py-1 border border-blue-600 rounded">
                                                            Daily
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Hourly Booking Button - Triggers Modal -->
                                                    <button onclick="openHourlyModal('{{ $car->id }}')" class="text-green-600 hover:text-green-900 px-3 py-1 border border-green-600 rounded">
                                                        Hourly
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <!-- <button onclick="openHourlyModal('{{ $car->id }}')" class="text-indigo-600 hover:text-indigo-900">
                                                    View Available Slots
                                                </button> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                            <p class="text-sm text-yellow-700">
                                No available cars at the moment.
                            </p>
                        </div>
                    @endif

                    <!-- My Bookings Section -->
                    <h2 class="text-xl font-semibold mb-4">My Bookings</h2>

                    @if($userBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Car Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date/Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Duration
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($userBookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $booking->car->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($booking->is_hourly)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Hourly</span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Daily</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($booking->is_hourly)
                                                    {{ $booking->booking_date->format('M d, Y') }}<br>
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                @else
                                                    {{ $booking->created_at->format('M d, Y') }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($booking->is_hourly)
                                                    {{ $booking->duration_hours }} hours
                                                @else
                                                    1 day
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 py-1 bg-{{ $booking->status === 'booked' ? 'green' : 'red' }}-100 text-{{ $booking->status === 'booked' ? 'green' : 'red' }}-800 rounded-full text-xs">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                               
                                                <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                        Cancel Booking
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <p class="text-sm text-blue-700">
                                You haven't booked any cars yet.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hourly Booking Modal -->
    <div id="hourlyBookingModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Hourly Booking
                    </h3>
                    <div class="mt-2">
                        <form id="hourlyBookingForm" method="POST" action="{{ route('user.bookings.store.hourly') }}">
                            @csrf
                            <input type="hidden" name="car_id" id="modalCarId">
                            <input type="hidden" name="booking_type" value="hourly">
                            
                            <div class="mb-4">
                                <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date</label>
                                <input type="date" name="booking_date" id="booking_date" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    min="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                                    <select name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @for($hour = 1; $hour <= 12; $hour++)
                                            <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="duration_hours" class="block text-sm font-medium text-gray-700">Duration (hours)</label>
                                    <select name="duration_hours" id="duration_hours" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }} hour{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">End Time: <span id="endTimeDisplay">09:00</span></p>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Confirm Booking
                                </button>
                                <button type="button" onclick="closeHourlyModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                               
                                                
                                           
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script>
        // Hourly Booking Modal Functions
        function openHourlyModal(carId) {
            document.getElementById('modalCarId').value = carId;
            document.getElementById('hourlyBookingModal').classList.remove('hidden');
            updateEndTimeDisplay();
        }
        
        function closeHourlyModal() {
            document.getElementById('hourlyBookingModal').classList.add('hidden');
        }
        
        // Time Calculation
        function updateEndTimeDisplay() {
            const startTime = document.getElementById('start_time').value;
            const duration = document.getElementById('duration_hours').value;
            
            if (startTime && duration) {
                const [hours, minutes] = startTime.split(':').map(Number);
                const endTime = new Date();
                endTime.setHours(hours + parseInt(duration));
                endTime.setMinutes(minutes);
                
                const endHours = endTime.getHours().toString().padStart(2, '0');
                const endMinutes = endTime.getMinutes().toString().padStart(2, '0');
                
                document.getElementById('endTimeDisplay').textContent = `${endHours}:${endMinutes}`;
            }
        }
        
        // Event Listeners
        document.getElementById('start_time').addEventListener('change', updateEndTimeDisplay);
        document.getElementById('duration_hours').addEventListener('change', updateEndTimeDisplay);
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('hourlyBookingModal')) {
                closeHourlyModal();
            }
        });
    </script>
</x-app-layout>
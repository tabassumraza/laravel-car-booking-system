<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>
    <!-- Register a new User -->
    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            href="{{ route('admin.users.create') }}">
            {{ __('Registered New User Account') }}
        </a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats and Recent Users Section -->
            <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Recent Users</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Joined</th>
                                <th class="text-left">Role</th>
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $user->is_admin ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                      <td class="flex space-x-2">
    <!-- Edit User Button -->
    <a href="{{ route('admin.users.edit', $user->id) }}" 
       class="text-blue-500 hover:underline">
       EDIT✏️
    </a>
    
    <!-- Delete Form -->
    <form action="{{ route('admin.users.destroy', $user->id) }}" 
          method="POST" 
          onsubmit="return confirm('Are you sure you want to delete this user?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:underline">
            DELETE🗑️
        </button>
    </form>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Car Listings</h2>
                        <!-- ADD NEW CAR BUTTON -->
                        <a href="{{ route('admin.car.add') }}" class="btn btn-primary">
                            Add New Car
                        </a>
                    </div>

                    @if($cars->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Car
                                            Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cars as $car)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $car->name }}</td>
                                            <td class="px-6 py-4">{{ $car->carnum }}</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full 
                                                                    {{ $car->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($car->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ Str::limit($car->description, 50) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <!-- BUTTON TO EDIT CAR DETAILS -->
                                                <button class="text-blue-500 hover:underline editBtn inline-block"
                                                    data-id="{{ $car->id }}" 
                                                    data-name="{{ $car->name }}"
                                                    data-carnum="{{ $car->carnum }}" 
                                                    data-status="{{ $car->status }}"
                                                    data-description="{{ $car->description }}">
                                                    EDIT✏️
                                                </button>

                                                <!-- BUTTON TO DELETE CAR -->
                                                <form action="{{ route('admin.car.remove') }}" method="POST"
                                                    class="inline-block ml-2" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    <input required type="hidden" value="{{ $car->id }}" name="id">
                                                    <button type="submit"
                                                        class="text-red-500 hover:underline">DELETE🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-yellow-700">No cars found in the database.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit/Update Car Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Edit Car Details</h2>
                <button id="closeEditModal" class="text-gray-600 hover:text-gray-800">✖</button>
            </div>
            <form id="editForm" method="POST" onsubmit="return confirmUpdate()">
                @csrf
                <input required type="hidden" name="id" id="editId">

                <div class="mb-4">
                    <label class="block mb-1">Name</label>
                    <input required type="text" name="name" id="editname" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Car Number</label>
                    <input required type="text" name="carnum" id="editcarnum" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Status</label>
                    <select name="status" id="editstatus" class="w-full border p-2 rounded">
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Description</label>
                    <textarea name="description" id="editdescription" class="w-full border p-2 rounded"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editId').value = this.dataset.id;
                document.getElementById('editname').value = this.dataset.name;
                document.getElementById('editcarnum').value = this.dataset.carnum;
                document.getElementById('editstatus').value = this.dataset.status;
                document.getElementById('editdescription').value = this.dataset.description;

                // Update form action dynamically
                document.getElementById('editForm').action = `/admin/car/update/${this.dataset.id}`;
            });
        });

        document.getElementById('closeEditModal').addEventListener('click', function () {
            document.getElementById('editModal').classList.add('hidden');
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this car?');
        }

        function confirmUpdate() {
            return confirm('Are you sure you want to update this car?');
        }
   

      
    </script>
</x-app-layout>
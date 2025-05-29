<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats and Recent Users Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                Admin Stats Card
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium">Total Users</h3>
                        <p class="text-2xl mt-2">{{ $userCount }}</p>
                    </div>
                </div>

                Recent Users Table
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium mb-4">Recent Users</h3>
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Car Listings</h2>
                        <!-- ADD NEW CAR BUTTON  -->
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">car
                                            number
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
                                            <!-- <td class="px-6 py-4 whitespace-nowrap">
                                                                        @if($car->picture)
                                                                            <img src="{{ $car->picture }}" alt="{{ $car->name }}" class="h-10">
                                                                        @else
                                                                            No Image
                                                                        @endif
                                                                    </td> -->
                                            <td class="px-6 py-4">{{ Str::limit($car->carnum, 50) }}</td>

                                            <td class="px-6 py-4">{{ Str::limit($car->description, 50) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <!-- BUTTON TO EDIT CAR DETAILS  -->
                                                <button class="text-blue-500 hover:underline editBtn inline-block"
                                                    data-id="{{ $car->id }}" 
                                                    data-name="{{ $car->name }}"
                                                    data-carnum="{{ $car->carnum }}" 
                                                    data-description="{{ $car->description }}">
                                                    EDIT✏️
                                                </button>

                                                <!-- BUTTON TO DELETE CAR  -->
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
    <!-- Edit/Update Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">edit button</h2>
                <button id="closeEditModal" class="text-gray-600 hover:text-gray-800">✖</button>
            </div>
            <form id="editForm" method="POST" onsubmit="return confirmUpdate()">
                @csrf
                @method('POST')
                <input required type="hidden" name="id" id="editId">

                <div class="mb-4">
                    <label class="block mb-1"> name</label>
                    <input required type="text" name="name" id="editname" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1"> car number</label>
                    <input required type="text" name="carnum" id="editcarnum" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1"> description</label>
                    <input required type="text" name="description" id="editdescription"
                        class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class=""> save updated version</button>
                </div>
            </form>
        </div>
    </div>
<script>
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editModal').classList.remove('hidden');

            document.getElementById('editId').value = this.dataset.id;
            document.getElementById('editname').value = this.dataset.name;
            document.getElementById('editcarnum').value = this.dataset.carnum;
            document.getElementById('editdescription').value = this.dataset.description;

            // Update form action dynamically
            document.getElementById('editForm').action = `car/update/${this.dataset.id}`;
        });
    });

    document.getElementById('closeEditModal').addEventListener('click', function() {
        document.getElementById('editModal').classList.add('hidden');
    });
</script>

</x-app-layout>
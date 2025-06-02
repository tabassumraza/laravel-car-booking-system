<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>
    <div class="testbox">
        <form action="{{ route('cars.store') }}" method="POST">
            @csrf

            <h1>Form for listing car</h1>

            <div class="item">
                <p>Car Details</p>
                <div class="name-item">
                    <input type="text" name="name" placeholder="Name of the car" required />
                </div>
            </div>
            
            <div class="item">
                <p>Car Number</p>
                <div class="name-item">
                    <input type="text" name="carnum" placeholder="Car number" required />
                </div>
            </div>
            
            <div class="item">
                <p>Status</p>
                <div class="name-item">
                    <select name="status" class=" p-2 border rounded" required>
                        <option value="available" selected>Available</option>
                        <option value="booked">Booked</option>
                    </select>
                </div>
            </div>
            
            <div class="item">
                <p>Description</p>
                <textarea name="description" placeholder="What best describes the car" required></textarea>
            </div>

            <div class="flex mt-4 space-x-2">
                <button type="submit" class="btn btn-primary">Send car to list</button>
            </div>
        </form>
    </div>
</x-app-layout>
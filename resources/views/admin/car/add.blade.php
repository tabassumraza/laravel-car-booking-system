<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>
   <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <form action="{{ route('cars.store') }}" method="POST" class="space-y-6">
        @csrf

        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">List Your Car</h1>

        <!-- Car Name -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Car Name</label>
            <input type="text" name="name" placeholder="e.g. Toyota Camry 2023" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Car Number -->
        <div class="space-y-2">
            <label for="carnum" class="block text-sm font-medium text-gray-700">License Plate Number</label>
            <input type="text" name="carnum" id="carnum" 
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('carnum') border-red-500 @enderror"
                   value="{{ old('carnum') }}" 
                   placeholder="e.g. ABC1234" required>
            @error('carnum')
                <p class="text-sm text-red-600 mt-1">This car number already exists</p>
            @enderror
        </div>

        <!-- Status -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Availability Status</label>
            <select name="status" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="available" selected>Available for Booking</option>
                <option value="booked">Currently Booked</option>
                <option value="maintenance">Under Maintenance</option>
            </select>
        </div>

        <!-- Description -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Car Description</label>
            <textarea name="description" rows="4" placeholder="Describe features, condition, and special notes..." required
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center mt-8">
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                List My Car
            </button>
        </div>
    </form>
</div>
</x-app-layout>
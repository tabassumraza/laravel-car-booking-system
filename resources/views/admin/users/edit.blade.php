<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" type="text" name="name" value="{{ $user->name }}" required autofocus
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ $user->email }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="is_admin" class="block text-sm font-medium text-gray-700">Role</label>
                            <select id="is_admin" name="is_admin"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Regular User</option>
                                <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <!-- Password -->
                        <!-- <div class="mb-4">
                            <label for="update_password_current_password"
                                class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" id="update_password_current_password" name="current_password"
                                autocomplete="current-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @if($errors->updatePassword->get('current_password'))
                                <div class="mt-2 text-sm text-red-600">
                                    @foreach($errors->updatePassword->get('current_password') as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div> -->

                        <!-- <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" id="password" name="password"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @if($errors->updatePassword->get('password'))
                                <div class="mt-2 text-sm text-red-600">
                                    @foreach($errors->updatePassword->get('password') as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div> -->

                        <!-- <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" id="password_confirmation"
                                name="password_confirmation" autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @if($errors->updatePassword->get('password_confirmation'))
                                <div class="mt-2 text-sm text-red-600">
                                    @foreach($errors->updatePassword->get('password_confirmation') as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div> -->

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
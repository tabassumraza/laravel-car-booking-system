<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                Admin Stats Cards
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
        </div>
    </div>
    <div class="testbox">
      <form action="{{url('addlist')}}">
        <h1> Form for listing car </h1>
        <div class="item">
          <p>cars list</p>
          <div class="name-item">
            <input type="text" name="name" placeholder="Name of the car " />
            <input type="text" name="specification" placeholder="specification" />
          </div>
        </div>
        <div class="item">
          <p>What best describes the car</p>
          <input type="text" name="decription" required/>
        </div>
        <div class="btn-block">
          <button type="submit"  href="/">Send car to list</button>
        </div>
      </form>
    </div>
</x-app-layout>
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Car List</h1>
    <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">Add New Car</a>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Picture</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
            <tr>
                <td>{{ $car->name }}</td>
                <td>{{ $car->description }}</td>
                <td>{{ $car->picture }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
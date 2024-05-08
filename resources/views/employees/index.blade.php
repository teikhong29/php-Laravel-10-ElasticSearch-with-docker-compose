@extends('layout.base')

@section('content')
<div class="w-3/4 mx-auto mb-10">
    <h3 class="text-xl font-bold mb-4 text-center my-4 ">Employee List</h3>
    <div class="flex md:flex md:flex-grow flex-row justify-end space-x-10">
        <form action="{{ route('employees.search') }}" method="GET">
            <input class="border-solid border-2 border-indigo-600 ..." type="text" name="search" placeholder="Search Employees">
            <button class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" type="submit">Search</button>
        </form>
        <a href="{{ route('employees.create') }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-700">Add new Employee</a>
    </div>
</div>    

<table class="w-3/4 mx-auto">
    <thead>
        <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">firstname</th>
            <th class="px-4 py-2">lastname</th>
            <th class="px-4 py-2">email</th>
            <th class="px-4 py-2">address</th>
            <th class="px-4 py-2">phone</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($Employes as $Employee)
            <tr>
                <td class="border px-4 py-2">{{ $Employee->id }}</td>
                <td class="border px-4 py-2">{{ $Employee->firstname }}</td>
                <td class="border px-4 py-2">{{ $Employee->lastname }}</td>
                <td class="border px-4 py-2">{{ $Employee->email }}</td>
                <td class="border px-4 py-2">{{ $Employee->address }}</td>

                <td class="border px-4 py-2">{{ $Employee->phone }}</td>
                <td class="border px-4 py-2">
                    <button class="bg-blue-500 text-white py-1 px-2 rounded">
                        <a href="{{ route('employees.edit' , $Employee->id) }}" class="text-white">Edit</a>
                    </button>
                    <!-- <button class="bg-yellow-500 text-white py-1 px-2 rounded">
                        <a href="{{ route('employees.show' , $Employee->id) }}" class="text-white">View</a>
                    </button> -->
                    <form action="{{ url('/employees/' . $Employee->id) }}" method="post" class="inline">
                        @csrf 
                        @method('DELETE')
                        <button class="bg-red-500 text-white py-1 px-2 rounded" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
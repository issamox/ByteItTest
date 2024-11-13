@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-2xl font-bold">Clients List</h1>

        <!--  create a new clients -->
        <a href="{{ route('clients.create') }}" class="bg-green-500 text-white my-5 px-4 py-2 inline-block rounded hover:bg-yellow-600">Create New Client</a>

        <!-- Clients Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-bold mb-6">Clients List</h2>

            <table class="min-w-full table-auto">
                <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">phone</th>
                    <th class="py-3 px-6 text-left">address</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($clients as $client)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $client->name }}</td>
                        <td class="py-3 px-6">{{ $client->email }}</td>
                        <td class="py-3 px-6">{{ $client->phone }}</td>
                        <td class="py-3 px-6">{{ $client->address }}</td>

                        <td class="py-3 px-6">
                            <a href="{{ route('clients.edit', $client->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded ml-2 hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mx-auto mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection

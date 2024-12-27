@extends('layouts.app') <!-- Adjust based on your layout -->
@section('title', 'Farmers List')

@section('content')
<div class="container">
    <h1 class="mb-4">Farmers</h1>
    <a href="{{ route('farmers.create') }}" class="btn btn-primary mb-3">Add New Farmer</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile Number</th>
                <th>NRC Number</th>
                <th>Type of Farm</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($farmers as $farmer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $farmer->first_name }}</td>
                    <td>{{ $farmer->last_name }}</td>
                    <td>{{ $farmer->mobile_number }}</td>
                    <td>{{ $farmer->nrcs_number }}</td>
                    <td>{{ $farmer->type_of_farm }}</td>
                    <td>{{ ucfirst($farmer->category) }}</td>
                    <td>
                        <a href="{{ route('farmers.edit', $farmer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('farmers.destroy', $farmer->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this farmer?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No farmers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $farmers->links() }}
    </div>
</div>
@endsection

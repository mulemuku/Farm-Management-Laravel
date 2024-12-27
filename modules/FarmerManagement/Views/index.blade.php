@extends('layouts.app')

@section('title', 'Farmers List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Farmers List</h2>
    <a href="{{ route('farmers.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-person-plus-fill"></i> Add Farmer
    </a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm border rounded">
            <thead class="table-success text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>City</th>
                    <th>NRC Number</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($farmers as $farmer)
                    <tr class="text-center">
                        <td>{{ $loop->iteration + ($farmers->currentPage() - 1) * $farmers->perPage() }}</td>
                        <td>{{ $farmer->first_name }} {{ $farmer->last_name }}</td>
                        <td>{{ $farmer->mobile_number }}</td>
                        <td>{{ $farmer->city }}</td>
                        <td>{{ $farmer->nrcs_number }}</td>
                        <td>
                            <span class="badge bg-{{ $farmer->status === 'active' ? 'success' : ($farmer->status === 'suspended' ? 'warning' : ($farmer->status === 'inactive' ? 'secondary' : 'primary')) }}">
                                {{ ucfirst($farmer->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $farmer->category === 'commercial' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($farmer->category) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('farmers.edit', $farmer->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <button class="btn btn-sm btn-danger delete-button" data-id="{{ $farmer->id }}">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No farmers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $farmers->links() }}
    </div>
</div>

<!-- Modal for Confirm Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this farmer? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const farmerId = button.getAttribute('data-id');
                deleteForm.action = `/farmers/${farmerId}`;
                deleteModal.show();
            });
        });
    });
</script>
@endpush

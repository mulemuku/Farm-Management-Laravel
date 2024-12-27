@extends('layouts.app')

@section('title', 'Module Management')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-puzzle"></i> Module Management</h2>

    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModuleModal">
        <i class="bi bi-upload"></i> Install Module
    </a>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($modules->isEmpty())
        <div class="alert alert-info">
            No modules found. Start by creating or uploading a module.
        </div>
    @else
        <table class="table table-hover shadow-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Module</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->description }}</td>
                        <td>
                            <span class="badge bg-{{ $module->is_active ? 'success' : 'secondary' }}">
                                {{ $module->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('modules.toggle', $module->id) }}" method="POST" class="d-inline toggle-form">
                                @csrf
                                <button type="button" class="btn btn-sm btn-warning toggle-btn">
                                    {{ $module->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('modules.delete', $module->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Upload Module Modal -->
<div class="modal fade" id="uploadModuleModal" tabindex="-1" aria-labelledby="uploadModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('modules.install') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModuleModalLabel">Install Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="module" class="form-label">Module Zip File</label>
                        <input type="file" class="form-control" name="module" id="module" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Install</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Confirm before toggling module status
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.toggle-form');
                const action = this.innerText.trim();
                if (confirm(`Are you sure you want to ${action} this module?`)) {
                    form.submit();
                }
            });
        });

        // Confirm before deleting a module
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.delete-form');
                if (confirm('Are you sure you want to delete this module? This action cannot be undone.')) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

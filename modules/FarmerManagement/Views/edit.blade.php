@extends('layouts.app')

@section('title', 'Edit Farmer')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Farmer</h2>

    <!-- Status Message -->
    <div id="status-message" class="alert d-none" role="alert"></div>

    <div class="row">
        <!-- Left Container: Farmer Information -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>Farmer Information</h5>
                </div>
                <div class="card-body">
                    <form id="farmer-update-form" action="{{ route('farmers.update', $farmer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Display NRC and Name (Non-editable) -->
                        <div class="mb-3">
                            <label for="nrcs_number" class="form-label">NRC Number</label>
                            <input type="text" id="nrcs_number" class="form-control" value="{{ $farmer->nrcs_number }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $farmer->first_name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $farmer->last_name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $farmer->mobile_number) }}">
                        </div>

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $farmer->date_of_birth) }}">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $farmer->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ $farmer->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ $farmer->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="inactive" {{ $farmer->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" id="submit-button" class="btn btn-success mt-3">
                            <i class="bi bi-save"></i> Update Farmer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Container: Farmer Documents -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5>Farmer Documents</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if($farmer->nrc_passport_file)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>NRC/Passport</span>
                                <div>
                                    <a href="{{ asset($farmer->nrc_passport_file) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ asset($farmer->nrc_passport_file) }}" download class="btn btn-sm btn-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if($farmer->bank_statement)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Bank Statement</span>
                                <div>
                                    <a href="{{ asset($farmer->bank_statement) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ asset($farmer->bank_statement) }}" download class="btn btn-sm btn-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if($farmer->other_documents)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Other Documents</span>
                                <div>
                                    <a href="{{ asset($farmer->other_documents) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ asset($farmer->other_documents) }}" download class="btn btn-sm btn-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if(!$farmer->nrc_passport_file && !$farmer->bank_statement && !$farmer->other_documents)
                            <li class="list-group-item text-center text-muted">No documents available.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Processing...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('farmer-update-form');
    const statusDiv = document.getElementById('status-message');
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        statusDiv.classList.add('d-none');
        loadingModal.show();
        submitButton.disabled = true;

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            });

            loadingModal.hide();
            submitButton.disabled = false;

            if (response.ok) {
                const result = await response.json();
                statusDiv.className = 'alert alert-success';
                statusDiv.innerHTML = `<i class="bi bi-check-circle"></i> ${result.message}`;
                statusDiv.scrollIntoView({ behavior: 'smooth' });
            } else {
                const errorData = await response.json();
                statusDiv.className = 'alert alert-danger';
                statusDiv.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${errorData.message || 'An error occurred.'}`;
                statusDiv.scrollIntoView({ behavior: 'smooth' });
            }
        } catch (error) {
            loadingModal.hide();
            submitButton.disabled = false;
            statusDiv.className = 'alert alert-danger';
            statusDiv.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${error.message || 'Unexpected error occurred.'}`;
            statusDiv.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>
@endpush

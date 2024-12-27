@extends('layouts.app')

@section('title', 'Add Farmer')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add Farmer</h2>

    <!-- Success/Failure Messages -->
    <div id="form-status" class="alert d-none" role="alert"></div>

    <!-- Farmer Form -->
    <form id="farmer-form" action="{{ route('farmers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information Section -->
        <h5 class="mb-3">Personal Information</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nrcs_number" class="form-label">NRC Number</label>
                <input type="text" name="nrcs_number" id="nrcs_number" class="form-control" value="{{ old('nrcs_number') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="next_of_kin" class="form-label">Next of Kin</label>
                <input type="text" name="next_of_kin" id="next_of_kin" class="form-control" value="{{ old('next_of_kin') }}" required>
            </div>
        </div>

        <!-- Location Section -->
        <h5 class="mb-3">Location Information</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
            </div>
            <div class="col-12 mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>
        </div>

        <!-- Farm Information Section -->
        <h5 class="mb-3">Farm Information</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type_of_farm" class="form-label">Type of Farm</label>
                <input type="text" name="type_of_farm" id="type_of_farm" class="form-control" value="{{ old('type_of_farm') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="commercial" {{ old('category') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="subsistent" {{ old('category') === 'subsistent' ? 'selected' : '' }}>Subsistent</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="land_area" class="form-label">Land Area (in hectares)</label>
                <input type="number" step="0.01" name="land_area" id="land_area" class="form-control" value="{{ old('land_area') }}">
            </div>
        </div>

        <!-- Documents Section -->
        <h5 class="mb-3">Documents</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nrc_passport_file" class="form-label">NRC/Passport File</label>
                <input type="file" name="nrc_passport_file" id="nrc_passport_file" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label for="bank_statement" class="form-label">Bank Statement (Optional)</label>
                <input type="file" name="bank_statement" id="bank_statement" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label for="other_documents" class="form-label">Other Documents (Optional)</label>
                <input type="file" name="other_documents" id="other_documents" class="form-control">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-end">
            <button type="submit" id="submit-button" class="btn btn-success">
                <i class="bi bi-cloud-upload"></i> Add Farmer
            </button>
        </div>
    </form>
</div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="d-none text-center">
    <div class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('farmer-form');
    const statusDiv = document.getElementById('form-status');
    const loadingSpinner = document.getElementById('loading-spinner');
    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        statusDiv.classList.add('d-none');
        loadingSpinner.classList.remove('d-none');
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

            const result = await response.json();

            loadingSpinner.classList.add('d-none');
            submitButton.disabled = false;

            if (response.ok) {
                statusDiv.className = 'alert alert-success';
                statusDiv.innerHTML = `<i class="bi bi-check-circle"></i> ${result.message}`;
                form.reset();
                window.scrollTo(0, statusDiv.offsetTop);
            } else {
                throw new Error(result.message || 'Validation error occurred');
            }
        } catch (error) {
            loadingSpinner.classList.add('d-none');
            submitButton.disabled = false;
            statusDiv.className = 'alert alert-danger';
            statusDiv.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${error.message}`;
            window.scrollTo(0, statusDiv.offsetTop);
        }

        statusDiv.classList.remove('d-none');
    });
});
</script>
@endpush

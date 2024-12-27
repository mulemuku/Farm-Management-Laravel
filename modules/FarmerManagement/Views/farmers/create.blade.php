@extends('layouts.app') <!-- Adjust based on your layout -->
@section('title', 'Farmers List')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ isset($farmer) ? 'Edit Farmer' : 'Add New Farmer' }}</h1>
    <form action="{{ isset($farmer) ? route('farmers.update', $farmer->id) : route('farmers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($farmer))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $farmer->first_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $farmer->last_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $farmer->mobile_number ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="nrcs_number" class="form-label">NRC Number</label>
            <input type="text" name="nrcs_number" id="nrcs_number" class="form-control" value="{{ old('nrcs_number', $farmer->nrcs_number ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $farmer->date_of_birth ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="type_of_farm" class="form-label">Type of Farm</label>
            <input type="text" name="type_of_farm" id="type_of_farm" class="form-control" value="{{ old('type_of_farm', $farmer->type_of_farm ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-select" required>
                <option value="commercial" {{ old('category', $farmer->category ?? '') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                <option value="subsistent" {{ old('category', $farmer->category ?? '') === 'subsistent' ? 'selected' : '' }}>Subsistent</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nrc_passport_file" class="form-label">NRC/Passport File</label>
            <input type="file" name="nrc_passport_file" id="nrc_passport_file" class="form-control">
        </div>

        <div class="mb-3">
            <label for="bank_statement" class="form-label">Bank Statement (Optional)</label>
            <input type="file" name="bank_statement" id="bank_statement" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">{{ isset($farmer) ? 'Update Farmer' : 'Add Farmer' }}</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Add Loan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-cash-stack"></i> Add Loan
    </h2>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> Please correct the following errors:
            <ul class="mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST" class="shadow p-4 bg-light rounded">
        @csrf

        <div class="mb-3">
            <label for="farmer_id" class="form-label"><i class="bi bi-person"></i> Farmer</label>
            <select name="farmer_id" id="farmer_id" class="form-select" required>
                <option value="" disabled selected>Select Farmer</option>
                @foreach($farmers as $farmer)
                    <option value="{{ $farmer->id }}" {{ old('farmer_id') == $farmer->id ? 'selected' : '' }}>
                        {{ $farmer->first_name }} {{ $farmer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="loan_amount" class="form-label"><i class="bi bi-currency-dollar"></i> Loan Amount</label>
            <input type="number" name="loan_amount" id="loan_amount" class="form-control" step="0.01" 
                   value="{{ old('loan_amount') }}" placeholder="Enter loan amount" required>
        </div>

        <div class="mb-3">
            <label for="interest_rate" class="form-label"><i class="bi bi-percent"></i> Interest Rate (%)</label>
            <input type="number" name="interest_rate" id="interest_rate" class="form-control" step="0.01" 
                   value="{{ old('interest_rate') }}" placeholder="Enter interest rate" required>
        </div>

        <div class="mb-3">
            <label for="repayment_duration_months" class="form-label"><i class="bi bi-calendar"></i> Repayment Duration (Months)</label>
            <input type="number" name="repayment_duration_months" id="repayment_duration_months" class="form-control" 
                   value="{{ old('repayment_duration_months') }}" placeholder="Enter repayment duration" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Submit
        </button>
    </form>
</div>
@endsection

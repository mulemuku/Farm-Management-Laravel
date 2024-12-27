@extends('layouts.app')

@section('title', 'Loan Management')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-cash-stack"></i> Loan Management
    </h2>

    <a href="{{ route('loans.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Add Loan
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm border rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th><i class="bi bi-person"></i> Farmer</th>
                    <th><i class="bi bi-currency-dollar"></i> Amount</th>
                    <th><i class="bi bi-percent"></i> Interest Rate</th>
                    <th><i class="bi bi-calendar"></i> Duration</th>
                    <th><i class="bi bi-info-circle"></i> Status</th>
                    <th><i class="bi bi-gear"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loan->farmer->first_name }} {{ $loan->farmer->last_name }}</td>
                        <td>ZMW {{ number_format($loan->loan_amount, 2) }}</td>
                        <td>{{ $loan->interest_rate }}%</td>
                        <td>{{ $loan->repayment_duration_months }} months</td>
                        <td>
                            <span class="badge bg-{{ $loan->status === 'pending' ? 'warning' : ($loan->status === 'approved' ? 'success' : ($loan->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td>
                            @if($loan->status === 'pending')
                                <form action="{{ route('loans.approve', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('loans.reject', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </form>
                            @elseif($loan->status === 'approved')
                                <form action="{{ route('loans.repay', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-cash"></i> Mark as Repaid
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No loans found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $loans->links() }}
    </div>
</div>
@endsection

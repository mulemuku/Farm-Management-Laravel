@extends('layouts.app')

@section('title', 'Loan Reports')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-bar-chart"></i> Loan Reports</h2>

    <!-- Filters -->
    <form method="GET" action="{{ route('loans.reports') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by farmer">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Summaries -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Disbursed</h5>
                    <p class="h4">ZMW {{ number_format($totalDisbursed, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Loans by Status</h5>
                    @foreach($loansByStatus as $status)
                        <p>{{ ucfirst($status->status) }}: {{ $status->count }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Loans Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Farmer</th>
                <th>Loan Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loan->farmer->first_name }} {{ $loan->farmer->last_name }}</td>
                    <td>ZMW {{ number_format($loan->loan_amount, 2) }}</td>
                    <td>{{ ucfirst($loan->status) }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $loans->links() }}
    </div>
</div>
@endsection

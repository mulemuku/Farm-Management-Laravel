@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-graph-up"></i> Loan Reports</h2>

    <!-- Filters -->
    <form method="GET" action="{{ route('reports.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by user name" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('reports.export') }}" class="btn btn-success float-end">
                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                </a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-hover shadow-sm">
        <thead>
            <tr>
                <th>Total Loans</th>
                <th>Total Amount Disbursed</th>
                <th>Approved Loans</th>
                <th>Pending Loans</th>
                <th>Rejected Loans</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->total_loans }}</td>
                <td>{{ number_format($data->total_disbursed, 2) }}</td>
                <td>{{ $data->approved }}</td>
                <td>{{ $data->pending }}</td>
                <td>{{ $data->rejected }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Create Module')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-puzzle"></i> Create Module
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="module_name" class="form-label">Module Name</label>
            <input type="text" name="module_name" id="module_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Create Module
        </button>
    </form>
</div>
@endsection

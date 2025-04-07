@extends('layouts.app')

@section('title', 'Create Position')

@section('page-title', 'Create New Position')

@section('content')
<div class="card max-w-lg mx-auto">
    <form action="{{ route('positions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code" class="form-label">Position Code</label>
            <input type="text" id="code" name="code" class="form-input" value="{{ old('code') }}" required>
            <p class="text-gray-500 text-sm mt-1">Short code for the position (e.g. MGR, DEV, QA)</p>
            @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="name" class="form-label">Position Name</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('positions.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Create Position</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit Division')

@section('page-title', 'Edit Division')

@section('content')
<div class="card max-w-lg mx-auto">
    <form action="{{ route('divisions.update', $division['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code" class="form-label">Division Code</label>
            <input type="text" id="code" name="code" class="form-input" value="{{ old('code', $division['code']) }}" required>
            <p class="text-gray-500 text-sm mt-1">Short code for the division (e.g. HR, IT, FIN)</p>
            @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="name" class="form-label">Division Name</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $division['name']) }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('divisions.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Update Division</button>
        </div>
    </form>
</div>
@endsection
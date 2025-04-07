@extends('layouts.app')

@section('title', 'Create Role')

@section('page-title', 'Create New Role')

@section('content')
<div class="card max-w-lg mx-auto">
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="level" class="form-label">Level</label>
            <input type="number" id="level" name="level" class="form-input" value="{{ old('level') }}" required>
            <p class="text-gray-500 text-sm mt-1">Higher level roles have more privileges</p>
            @error('level')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('roles.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Create Role</button>
        </div>
    </form>
</div>
@endsection
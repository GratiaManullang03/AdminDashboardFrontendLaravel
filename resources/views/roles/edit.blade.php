@extends('layouts.app')

@section('title', 'Edit Role')

@section('page-title', 'Edit Role')

@section('content')
<div class="card max-w-lg mx-auto">
    <form action="{{ route('roles.update', $role['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $role['name']) }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="level" class="form-label">Level</label>
            <input type="number" id="level" name="level" class="form-input" value="{{ old('level', $role['level']) }}" required>
            <p class="text-gray-500 text-sm mt-1">Higher level roles have more privileges</p>
            @error('level')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('roles.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Update Role</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')
<div class="card">
    <form action="{{ route('users.update', $user['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label class="form-label">Employee ID</label>
                <p class="form-input bg-gray-100">{{ $user['employee_id'] }}</p>
            </div>
            
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user['name']) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user['email']) }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user['phone']) }}">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $user['address']) }}">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" class="form-input" value="{{ old('birthdate', $user['birthdate']) }}">
                @error('birthdate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="division_id" class="form-label">Division</label>
                <select id="division_id" name="division_id" class="form-input">
                    <option value="">Select Division</option>
                    @foreach($divisions ?? [] as $division)
                        <option 
                            value="{{ $division['id'] }}" 
                            {{ old('division_id', isset($user['division_id']) ? $user['division_id'] : '') == $division['id'] ? 'selected' : '' }}
                        >
                            {{ $division['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('division_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="position_id" class="form-label">Position</label>
                <select id="position_id" name="position_id" class="form-input">
                    <option value="">Select Position</option>
                    @foreach($positions ?? [] as $position)
                        <option 
                            value="{{ $position['id'] }}" 
                            {{ old('position_id', isset($user['position_id']) ? $user['position_id'] : '') == $position['id'] ? 'selected' : '' }}
                        >
                            {{ $position['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('position_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label block mb-2">Is Manager?</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center mr-4">
                        <input 
                            type="radio" 
                            name="is_manager" 
                            value="1" 
                            {{ old('is_manager', $user['is_manager']) ? 'checked' : '' }} 
                            class="form-radio"
                        >
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input 
                            type="radio" 
                            name="is_manager" 
                            value="0" 
                            {{ old('is_manager', $user['is_manager']) ? '' : 'checked' }} 
                            class="form-radio"
                        >
                        <span class="ml-2">No</span>
                    </label>
                </div>
                @error('is_manager')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label block mb-2">Status</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center mr-4">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $user['is_active']) ? 'checked' : '' }} 
                            class="form-radio"
                        >
                        <span class="ml-2">Active</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="0" 
                            {{ old('is_active', $user['is_active']) ? '' : 'checked' }} 
                            class="form-radio"
                        >
                        <span class="ml-2">Inactive</span>
                    </label>
                </div>
                @error('is_active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="role_ids" class="form-label">Roles</label>
                <div class="mt-2">
                    @foreach($roles ?? [] as $role)
                        <label class="inline-flex items-center mr-4 mb-2">
                            <input 
                                type="checkbox" 
                                name="role_ids[]" 
                                value="{{ $role['id'] }}" 
                                {{ in_array($role['name'], old('role_ids', $user['roles'] ?? [])) ? 'checked' : '' }}
                                class="form-checkbox"
                            >
                            <span class="ml-2">{{ $role['name'] }}</span>
                        </label>
                    @endforeach
                </div>
                @error('role_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Update User</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1">
        <div class="card text-center">
            <div class="mb-4">
                <div class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if(!empty($profile['profile_image']))
                        <img src="{{ $profile['profile_image'] }}" alt="{{ $profile['name'] }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-gray-400 text-5xl"></i>
                    @endif
                </div>
            </div>
            
            <h2 class="text-xl font-semibold">{{ $profile['name'] }}</h2>
            <p class="text-gray-500">{{ $profile['employee_id'] }}</p>
            
            <div class="mt-4">
                @foreach($profile['roles'] ?? [] as $role)
                    <span class="badge badge-success">{{ $role }}</span>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="md:col-span-2">
        <div class="card">
            <h2 class="text-lg font-semibold mb-4">Profile Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-500 text-sm">Full Name</label>
                    <p class="font-medium">{{ $profile['name'] }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Email</label>
                    <p class="font-medium">{{ $profile['email'] }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Phone</label>
                    <p class="font-medium">{{ $profile['phone'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Address</label>
                    <p class="font-medium">{{ $profile['address'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Birthdate</label>
                    <p class="font-medium">{{ $profile['birthdate'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Join Date</label>
                    <p class="font-medium">{{ $profile['join_date'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Division</label>
                    <p class="font-medium">{{ $profile['division'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Position</label>
                    <p class="font-medium">{{ $profile['position'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Manager</label>
                    <p class="font-medium">{{ $profile['manager'] ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 text-sm">Status</label>
                    <p class="font-medium">
                        @if($profile['is_active'])
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Users')

@section('page-title', 'User Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <form action="{{ route('users.index') }}" method="GET" class="flex items-center">
            <input 
                type="text" 
                name="search" 
                placeholder="Search users..." 
                class="form-input h-10 px-3 py-2 rounded-l-md"
                value="{{ $search ?? '' }}"
            >
            <button type="submit" class="bg-accent text-white px-4 py-2 rounded-r-md h-10 flex items-center">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <a href="{{ route('users.create') }}" class="btn-primary flex items-center">
        <i class="fas fa-plus mr-2"></i> Add User
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Division</th>
                    <th>Position</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['items'] ?? [] as $user)
                <tr>
                    <td>{{ $user['employee_id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['division'] ?? '-' }}</td>
                    <td>{{ $user['position'] ?? '-' }}</td>
                    <td>
                        @foreach($user['roles'] ?? [] as $role)
                            <span class="badge badge-success">{{ $role }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($user['is_active'])
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="flex">
                        <a href="{{ route('users.edit', $user['id']) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-id="{{ $user['id'] }}" data-type="user">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $user['id'] }}" action="{{ route('users.destroy', $user['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($data['total_pages']) && $data['total_pages'] > 1)
    <div class="mt-4 flex justify-between items-center">
        <div>
            Showing {{ count($data['items'] ?? []) }} of {{ $data['total_items'] ?? 0 }} users
        </div>
        <div class="flex">
            @for($i = 1; $i <= $data['total_pages']; $i++)
                <a 
                    href="{{ route('users.index', ['page' => $i, 'search' => $search]) }}" 
                    class="mx-1 px-3 py-1 rounded {{ $i == ($data['current_page'] ?? 1) ? 'bg-accent text-white' : 'bg-gray-200' }}"
                >
                    {{ $i }}
                </a>
            @endfor
        </div>
    </div>
    @endif
</div>
@endsection
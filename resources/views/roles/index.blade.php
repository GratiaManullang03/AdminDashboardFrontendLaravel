@extends('layouts.app')

@section('title', 'Roles')

@section('page-title', 'Role Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <form action="{{ route('roles.index') }}" method="GET" class="flex items-center">
            <input 
                type="text" 
                name="search" 
                placeholder="Search roles..." 
                class="form-input h-10 px-3 py-2 rounded-l-md"
                value="{{ $search ?? '' }}"
            >
            <button type="submit" class="bg-accent text-white px-4 py-2 rounded-r-md h-10 flex items-center">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <a href="{{ route('roles.create') }}" class="btn-primary flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Role
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['items'] ?? [] as $role)
                <tr>
                    <td>{{ $role['id'] }}</td>
                    <td>{{ $role['name'] }}</td>
                    <td>{{ $role['level'] }}</td>
                    <td>
                        @if($role['is_active'])
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="flex">
                        <a href="{{ route('roles.edit', $role['id']) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-id="{{ $role['id'] }}" data-type="role">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $role['id'] }}" action="{{ route('roles.destroy', $role['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No roles found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($data['total_pages']) && $data['total_pages'] > 1)
    <div class="mt-4 flex justify-between items-center">
        <div>
            Showing {{ count($data['items'] ?? []) }} of {{ $data['total_items'] ?? 0 }} roles
        </div>
        <div class="flex">
            @for($i = 1; $i <= $data['total_pages']; $i++)
                <a 
                    href="{{ route('roles.index', ['page' => $i, 'search' => $search]) }}" 
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
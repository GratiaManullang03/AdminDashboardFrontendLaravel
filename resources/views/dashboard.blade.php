@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 flex items-center">
            <div class="rounded-full bg-blue-100 p-3 mr-4">
                <i class="fas fa-users text-blue-500"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm">Total Users</h3>
                <p class="text-2xl font-semibold">{{ $stats['total_users'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 flex items-center">
            <div class="rounded-full bg-green-100 p-3 mr-4">
                <i class="fas fa-user-check text-green-500"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm">Active Users</h3>
                <p class="text-2xl font-semibold">{{ $stats['active_users'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 flex items-center">
            <div class="rounded-full bg-purple-100 p-3 mr-4">
                <i class="fas fa-building text-purple-500"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm">Divisions</h3>
                <p class="text-2xl font-semibold">{{ $stats['total_divisions'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 flex items-center">
            <div class="rounded-full bg-yellow-100 p-3 mr-4">
                <i class="fas fa-id-badge text-yellow-500"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm">Positions</h3>
                <p class="text-2xl font-semibold">{{ $stats['total_positions'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="text-lg font-semibold mb-4">Users Per Division</h2>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Division</th>
                        <th>Number of Users</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['users_per_division'] ?? [] as $divisionStat)
                    <tr>
                        <td>{{ $divisionStat['division'] }}</td>
                        <td>{{ $divisionStat['count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card">
        <h2 class="text-lg font-semibold mb-4">Users Per Position</h2>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Number of Users</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['users_per_position'] ?? [] as $positionStat)
                    <tr>
                        <td>{{ $positionStat['position'] }}</td>
                        <td>{{ $positionStat['count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-6">
    <h2 class="text-lg font-semibold mb-4">New Users This Month</h2>
    <div class="flex items-center justify-center">
        <div class="text-center">
            <span class="text-4xl font-bold text-accent">{{ $stats['new_users_this_month'] ?? 0 }}</span>
            <p class="text-gray-500">new users joined this month</p>
        </div>
    </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title', 'Home')</title>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --accent: #BF161C;
            --gray: #E0FBFC;
            --background: #253237;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar {
            background-color: var(--background);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar-logo {
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        .sidebar.collapsed .sidebar-logo {
            padding: 1.5rem 0.5rem;
            justify-content: center;
        }

        .normal-logo, .collapsed-logo {
            transition: all 0.3s;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.7);
            transition: all 0.3s;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--accent);
        }
        
        .menu-item i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: all 0.3s;
        }
        
        .main-content.expanded {
            margin-left: 70px;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-radius: 8px;
        }
        
        .btn-primary {
            background-color: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #a3141a;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8fafc;
        }
        
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #DEF7EC;
            color: #03543E;
        }
        
        .badge-warning {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .badge-danger {
            background-color: #FDE2E2;
            color: #9B1C1C;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d2d6dc;
            border-radius: 4px;
            background-color: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(191, 22, 28, 0.1);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div>
                    <!-- Logo untuk tampilan normal -->
                    <h2 class="text-xl font-bold normal-logo">Admin<span class="text-red-500">Panel</span></h2>
                    
                    <!-- Logo untuk tampilan collapsed (hanya ikon) -->
                    <h2 class="text-xl font-bold collapsed-logo" style="display:none;">A<span class="text-red-500">P</span></h2>
                </div>
                <button id="toggleSidebar" class="md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                
                <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">Users</span>
                </a>
                
                <a href="{{ route('roles.index') }}" class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tag"></i>
                    <span class="menu-text">Roles</span>
                </a>
                
                <a href="{{ route('divisions.index') }}" class="menu-item {{ request()->routeIs('divisions.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span class="menu-text">Divisions</span>
                </a>
                
                <a href="{{ route('positions.index') }}" class="menu-item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                    <i class="fas fa-id-badge"></i>
                    <span class="menu-text">Positions</span>
                </a>
                
                <a href="{{ route('profile') }}" class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span class="menu-text">Profile</span>
                </a>
                
                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="content">
            <div class="navbar">
                <div class="flex items-center">
                    <button id="sidebarCollapse" class="mr-4">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-bold">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center">
                    <div class="mr-4 relative">
                        <span class="text-sm font-medium">{{ session('user_name', 'Admin') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script>
        // Toggle Sidebar
        const sidebarCollapse = document.getElementById('sidebarCollapse');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuTexts = document.querySelectorAll('.menu-text');
        const normalLogo = document.querySelector('.normal-logo');
        const collapsedLogo = document.querySelector('.collapsed-logo');
        
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                menuTexts.forEach(text => {
                    text.style.display = 'none';
                });
                normalLogo.style.display = 'none';
                collapsedLogo.style.display = 'block';
            } else {
                menuTexts.forEach(text => {
                    text.style.display = 'block';
                });
                normalLogo.style.display = 'block';
                collapsedLogo.style.display = 'none';
            }
        });

        // Sweet Alert for delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    
                    let typeName = 'item';
                    if (type === 'user') typeName = 'user';
                    else if (type === 'role') typeName = 'role';
                    else if (type === 'division') typeName = 'division';
                    else if (type === 'position') typeName = 'position';
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You won't be able to revert this ${typeName} deletion!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#BF161C',
                        cancelButtonColor: '#d2d6dc',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                });
            });
        });
        
        // Sweet Alert for flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
    @yield('scripts')
</body>
</html>
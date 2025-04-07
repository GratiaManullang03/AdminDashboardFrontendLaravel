<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --accent: #BF161C;
            --gray: #E0FBFC;
            --background: #253237;
        }
        
        body {
            background-color: var(--background);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 400px;
            padding: 2rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--background);
        }
        
        .login-header span {
            color: var(--accent);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d2d6dc;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(191, 22, 28, 0.1);
        }
        
        .login-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .login-btn:hover {
            background-color: #a3141a;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Admin<span>Panel</span></h1>
            <p class="text-gray-600">Sign in to your account</p>
        </div>
        
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email address" 
                    class="form-input"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    class="form-input"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="login-btn">Sign In</button>
        </form>
    </div>
    
    <script>
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
</body>
</html>
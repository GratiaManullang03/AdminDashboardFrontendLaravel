protected $routeMiddleware = [
    // Middleware bawaan lainnya
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    // ... middleware lainnya
    
    // Tambahkan middleware kustom Anda di sini
    'api.auth' => \App\Http\Middleware\ApiAuthentication::class,
];
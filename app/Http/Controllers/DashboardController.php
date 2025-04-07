<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/dashboard/statistics');
            
            if ($response->successful()) {
                $stats = $response->json();
                return view('dashboard', compact('stats'));
            }
            
            return view('dashboard')->with('error', 'Failed to load statistics');
        } catch (\Exception $e) {
            return view('dashboard')->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
}
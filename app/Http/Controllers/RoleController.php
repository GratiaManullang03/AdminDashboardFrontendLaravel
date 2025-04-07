<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/roles', [
                    'page' => $page,
                    'limit' => $limit,
                    'search' => $search,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return view('roles.index', compact('data', 'search'));
            }
            
            return back()->with('error', 'Failed to load roles');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        return view('roles.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'required|numeric',
        ]);
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->post(env('ADMIN_API_URL') . '/api/roles', $request->all());
            
            if ($response->successful()) {
                return redirect()->route('roles.index')->with('success', 'Role created successfully!');
            }
            
            return back()->with('error', 'Failed to create role: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/roles/' . $id);
            
            if ($response->successful()) {
                $role = $response->json();
                return view('roles.edit', compact('role'));
            }
            
            return back()->with('error', 'Failed to load role details');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'required|numeric',
        ]);
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->put(env('ADMIN_API_URL') . '/api/roles/' . $id, $request->all());
            
            if ($response->successful()) {
                return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
            }
            
            return back()->with('error', 'Failed to update role: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->delete(env('ADMIN_API_URL') . '/api/roles/' . $id);
            
            if ($response->successful()) {
                return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
            }
            
            return back()->with('error', 'Failed to delete role');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
}
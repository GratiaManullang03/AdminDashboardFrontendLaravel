<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/users', [
                    'page' => $page,
                    'limit' => $limit,
                    'search' => $search,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Get roles, divisions, and positions for create form
                $roles = $this->getRoles();
                $divisions = $this->getDivisions();
                $positions = $this->getPositions();
                
                return view('users.index', compact('data', 'roles', 'divisions', 'positions', 'search'));
            }
            
            return back()->with('error', 'Failed to load users');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        // Get roles, divisions, and positions for create form
        $roles = $this->getRoles();
        $divisions = $this->getDivisions();
        $positions = $this->getPositions();
        
        return view('users.create', compact('roles', 'divisions', 'positions'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'join_date' => 'required|date',
        ]);
        
        // Debugging: Lihat data yang dikirim
        \Log::info('Request data:', $request->all());
        
        // Konversi tipe data secara eksplisit
        $data = [
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'join_date' => $request->join_date,
            'profile_image' => $request->profile_image,
            'is_manager' => (bool) $request->is_manager,
        ];
        
        // Handle nulls and conversions separately
        if ($request->filled('division_id')) {
            $data['division_id'] = (int) $request->division_id;
        }
        
        if ($request->filled('position_id')) {
            $data['position_id'] = (int) $request->position_id;
        }
        
        if ($request->filled('manager_id')) {
            $data['manager_id'] = (int) $request->manager_id;
        }
        
        if ($request->has('role_ids') && is_array($request->role_ids)) {
            $data['role_ids'] = array_map('intval', $request->role_ids);
        } else {
            $data['role_ids'] = [];
        }
        
        // Debugging: Lihat data setelah konversi
        \Log::info('Converted data:', $data);
        
        try {
            $jsonData = json_encode($data);
            \Log::info('JSON data:', ['data' => $jsonData]);
            
            $response = Http::withToken(Session::get('token'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(env('ADMIN_API_URL') . '/api/users', $data);
            
            // Debugging: Lihat respons
            \Log::info('Response status: ' . $response->status());
            \Log::info('Response body: ' . $response->body());
            
            if ($response->successful()) {
                return redirect()->route('users.index')->with('success', 'User created successfully!');
            }
            
            return back()->with('error', 'Failed to create user: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/users/' . $id);
            
            if ($response->successful()) {
                $user = $response->json();
                
                // Get roles, divisions, and positions for edit form
                $roles = $this->getRoles();
                $divisions = $this->getDivisions();
                $positions = $this->getPositions();
                
                return view('users.edit', compact('user', 'roles', 'divisions', 'positions'));
            }
            
            return back()->with('error', 'Failed to load user details');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        
        // Debugging: Lihat data yang dikirim
        \Log::info('Update Request data:', $request->all());
        
        // Konversi tipe data secara eksplisit
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
        ];
        
        // Handle nulls and conversions separately
        if ($request->filled('division_id')) {
            $data['division_id'] = (int) $request->division_id;
        }
        
        if ($request->filled('position_id')) {
            $data['position_id'] = (int) $request->position_id;
        }
        
        if ($request->filled('manager_id')) {
            $data['manager_id'] = (int) $request->manager_id;
        }
        
        if ($request->has('is_manager')) {
            $data['is_manager'] = (bool) $request->is_manager;
        }
        
        if ($request->has('is_active')) {
            $data['is_active'] = (bool) $request->is_active;
        }
        
        if ($request->has('role_ids') && is_array($request->role_ids)) {
            $data['role_ids'] = array_map('intval', $request->role_ids);
        } else {
            $data['role_ids'] = [];
        }
        
        // Debugging: Lihat data setelah konversi
        \Log::info('Converted update data:', $data);
        
        try {
            $jsonData = json_encode($data);
            \Log::info('JSON update data:', ['data' => $jsonData]);
            
            $response = Http::withToken(Session::get('token'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->put(env('ADMIN_API_URL') . '/api/users/' . $id, $data);
            
            // Debugging: Lihat respons
            \Log::info('Update Response status: ' . $response->status());
            \Log::info('Update Response body: ' . $response->body());
            
            if ($response->successful()) {
                return redirect()->route('users.index')->with('success', 'User updated successfully!');
            }
            
            return back()->with('error', 'Failed to update user: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            \Log::error('Update Exception: ' . $e->getMessage());
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->delete(env('ADMIN_API_URL') . '/api/users/' . $id);
            
            if ($response->successful()) {
                return redirect()->route('users.index')->with('success', 'User deleted successfully!');
            }
            
            return back()->with('error', 'Failed to delete user');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    private function getRoles()
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/roles/all');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
    
    private function getDivisions()
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/divisions/all');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
    
    private function getPositions()
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/positions/all');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
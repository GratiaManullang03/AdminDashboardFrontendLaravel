<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/positions', [
                    'page' => $page,
                    'limit' => $limit,
                    'search' => $search,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return view('positions.index', compact('data', 'search'));
            }
            
            return back()->with('error', 'Failed to load positions');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        return view('positions.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->post(env('ADMIN_API_URL') . '/api/positions', $request->all());
            
            if ($response->successful()) {
                return redirect()->route('positions.index')->with('success', 'Position created successfully!');
            }
            
            return back()->with('error', 'Failed to create position: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/positions/' . $id);
            
            if ($response->successful()) {
                $position = $response->json();
                return view('positions.edit', compact('position'));
            }
            
            return back()->with('error', 'Failed to load position details');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->put(env('ADMIN_API_URL') . '/api/positions/' . $id, $request->all());
            
            if ($response->successful()) {
                return redirect()->route('positions.index')->with('success', 'Position updated successfully!');
            }
            
            return back()->with('error', 'Failed to update position: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->delete(env('ADMIN_API_URL') . '/api/positions/' . $id);
            
            if ($response->successful()) {
                return redirect()->route('positions.index')->with('success', 'Position deleted successfully!');
            }
            
            return back()->with('error', 'Failed to delete position');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
}
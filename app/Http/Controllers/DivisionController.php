<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/divisions', [
                    'page' => $page,
                    'limit' => $limit,
                    'search' => $search,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return view('divisions.index', compact('data', 'search'));
            }
            
            return back()->with('error', 'Failed to load divisions');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        return view('divisions.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);
        
        // Konversi tipe data secara eksplisit (tidak ada field numerik disini)
        $data = [
            'code' => $request->code,
            'name' => $request->name,
        ];
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(env('ADMIN_API_URL') . '/api/divisions', $data);
            
            if ($response->successful()) {
                return redirect()->route('divisions.index')->with('success', 'Division created successfully!');
            }
            
            return back()->with('error', 'Failed to create division: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->get(env('ADMIN_API_URL') . '/api/divisions/' . $id);
            
            if ($response->successful()) {
                $division = $response->json();
                return view('divisions.edit', compact('division'));
            }
            
            return back()->with('error', 'Failed to load division details');
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
        
        // Konversi tipe data secara eksplisit (tidak ada field numerik disini)
        $data = [
            'code' => $request->code,
            'name' => $request->name,
        ];
        
        try {
            $response = Http::withToken(Session::get('token'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->put(env('ADMIN_API_URL') . '/api/divisions/' . $id, $data);
            
            if ($response->successful()) {
                return redirect()->route('divisions.index')->with('success', 'Division updated successfully!');
            }
            
            return back()->with('error', 'Failed to update division: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $response = Http::withToken(Session::get('token'))
                ->delete(env('ADMIN_API_URL') . '/api/divisions/' . $id);
            
            if ($response->successful()) {
                return redirect()->route('divisions.index')->with('success', 'Division deleted successfully!');
            }
            
            return back()->with('error', 'Failed to delete division');
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }
}
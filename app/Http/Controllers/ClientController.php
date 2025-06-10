<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $clients = Client::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'clients' => $clients,
            'message' => 'Clients fetched successfully',
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'zip' => 'nullable|string|max:255',
            ]);

            $validated['user_id'] = Auth::id();

            $client = Client::create($validated);

            return response()->json([
                'client' => $client,
                'message' => 'Client created successfully',
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Client creation failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client = Client::find($client->id);
        if (!$client) {
            return response()->json([
                'message' => 'Client not found',
                'status' => 'error',
            ], 404);
        }

        return response()->json([
            'client' => $client,
            'message' => 'Client fetched successfully',
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {

        try {
            $client = Client::find($client->id);
            if (!$client) {
                return response()->json([
                    'message' => 'Client not found',
                    'status' => 'error',
                ], 404);
            }

            $client->update($request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'contact_person' => 'nullable|string|max:255',
            ]));

            return response()->json([
                'client' => $client,
                'message' => 'Client updated successfully',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Client update failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client = Client::find($client->id);
        if (!$client) {
            return response()->json([
                'message' => 'Client not found',
                'status' => 'error',
            ], 404);
        }
        $client->delete();
        return response()->json([
            'message' => 'Client deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
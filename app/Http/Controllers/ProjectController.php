<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client')->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'projects' => $projects,
            'message' => 'Projects fetched successfully',
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
        try {

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'client_id' => 'required|exists:clients,id',
                'status' => 'required|in:active,completed',
                'deadline' => 'nullable|date'
            ]);

            $validated['user_id'] = Auth::id();

            $project = Project::create($validated);

            return response()->json([
                'project' => $project,
                'message' => 'Project created successfully',
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Project creation failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project = Project::find($project->id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found',
                'status' => 'error',
            ], 404);
        }
        $project->load('client');

        return response()->json([
            'project' => $project,
            'message' => 'Project fetched successfully',
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project = Project::find($project->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $project = Project::find($project->id);
            if (!$project) {
                return response()->json([
                    'message' => 'Project not found',
                    'status' => 'error',
                ], 404);
            }

            $project->update($request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,completed',
                'deadline' => 'nullable|date'
            ]));

            return response()->json([
                'project' => $project,
                'message' => 'Project updated successfully',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Project update failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project = Project::find($project->id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found',
                'status' => 'error',
            ], 404);
        }
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeLogRequest;
use App\Models\Project;
use App\Models\TimeLogs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::id());
        $timeLogs = TimeLogs::with('project')
            ->whereHas('project', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return response()->json([
            'timeLogs' => $timeLogs,
            'message' => 'Time logs fetched successfully',
            'status' => 'success',
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $rules = [
                'project_id' => 'required|exists:projects,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'description' => 'nullable|string',
            ];

            $messages = [
                'project_id.required' => 'Project is required',
                'project_id.exists' => 'Project not found',
                'start_time.required' => 'Start time is required',
                'end_time.required' => 'End time is required',
                'end_time.after' => 'End time must be after start time',
            ];

            // Validate
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            // Authorization check
            $project = Project::find($validated['project_id']);
            if (!$project) {
                return response()->json([
                    'message' => 'Project not found',
                    'status' => 'error',
                ], 404);
            }

            if ($project->user_id != Auth::id()) {
                return response()->json([
                    'message' => 'You are not authorized to create a time log for this project',
                    'status' => 'error',
                ], 403);
            }

            // Calculate hour
            $start = strtotime($validated['start_time']);
            $end = strtotime($validated['end_time']);
            $validated['hour'] = round(($end - $start) / 3600, 2);

            $timeLog = TimeLogs::create($validated);

            return response()->json([
                'timeLog' => $timeLog,
                'message' => 'Time log created successfully',
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Time log creation failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $timeLog = TimeLogs::find($id);

        return response()->json([
            'timeLog' => $timeLog,
            'message' => 'Time log fetched successfully',
            'status' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
            ]);
            $timeLog = TimeLogs::find($id);

            if (!$timeLog) {
                return response()->json([
                    'message' => 'Time log not found',
                    'status' => 'error',
                ], 404);
            }

            $start = strtotime($request->start_time);
            $end = strtotime($request->end_time);
            $validated['hour'] = ($end - $start) / 3600;

            $timeLog->update($validated);

            return response()->json([
                'timeLog' => $timeLog,
                'message' => 'Time log updated successfully',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Time log update failed',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timeLog = TimeLogs::find($id);
        if (!$timeLog) {
            return response()->json([
                'message' => 'Time log not found',
                'status' => 'error',
            ], 404);
        }
        $timeLog->delete();

        return response()->json([
            'message' => 'Time log deleted successfully',
            'status' => 'success',
        ]);
    }

    public function start($project_id)
    {
        $project = Project::find($project_id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        if ($project->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $timeLog = new TimeLogs();
        $timeLog->project_id = $project_id;
        $timeLog->start_time = now();
        $timeLog->save();

        return response()->json(['timeLog' => $timeLog, 'message' => 'Start time recorded']);
    }


    public function end($project_id)
    {
        $timeLog = TimeLogs::with('project')
            ->where('project_id', $project_id)
            ->where('end_time', null)
            ->first();
        if (!$timeLog) {
            return response()->json(['message' => 'Time log not found'], 404);
        }

        if ($timeLog->project->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $timeLog->end_time = now();
        $timeLog->hour = round((strtotime($timeLog->end_time) - strtotime($timeLog->start_time)) / 3600, 2);
        $timeLog->save();

        return response()->json(['timeLog' => $timeLog, 'message' => 'End time recorded']);
    }
}
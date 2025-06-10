<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }

        return response()->json([
            'user' => $user,
            'message' => 'Profile fetched successfully',
            'status' => 'success',
        ]);
    }
}
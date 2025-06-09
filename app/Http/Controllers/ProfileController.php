<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);

        return response()->json([
            'user' => $user,
            'message' => 'Profile fetched successfully',
            'status' => 'success',
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MainController extends Controller
{
    public function contactus(Request $request) {
        
        $user = User::where("email", $request->email)->first();
        
        if ($user) {
            $user->update([
                'notes' => $request->notes,
            ]);
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Get user successfully'
            ]);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user'
            ], 404);
        }
    }

    public function getLogin() {
        $user =  Auth::user();
        if ($user) {
            $isLogged =true;
            return $isLogged;
        }
        $isLogged = false;
    }
    
}

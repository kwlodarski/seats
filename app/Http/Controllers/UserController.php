<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Presence;

class UserController extends Controller
{
    public function getAllUsers(User $user)
    {
        $users = $user->get();
        $users->transform(function($user) {
            $user->is_active = $user->is_active ? true : false;
            return $user;
        });
        return response()->json( compact('users') );
    }

    public function getActiveUsers(User $user)
    {
        $users = $user->where('is_active', 1)->get();
        return response()->json( compact('users') );
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->employeeId);
        $presences = Presence::where('employee_id', $request->employeeId)->delete();
        $user->delete();
        return response()->json( compact('user') );
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->employeeId);
        $user->is_active = $request->is_active;
        $user->save();
        return response()->json( compact('user') );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presence;
use App\Models\Vacation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers(User $user)
    {
        $users = $user->orderBy('order')->get();
        $users->transform(function($user) {
            $user->is_active = $user->is_active ? true : false;
            return $user;
        });
        return response()->json( compact('users') );
    }

    public function getActiveUsers(User $user)
    {
        $users = $user->where('is_active', 1)->orderBy('order')->get();
        return response()->json( compact('users') );
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->employeeId);
        $presences = Presence::where('user_id', $request->employeeId)->delete();
        $vacations = Vacation::where('user_id', $request->employeeId)->delete();
        $user->delete();
        return response()->json( compact('user') );
    }

    public function editUser(Request $request)
    {
        $errors = [];
        $user = User::find($request->employeeId);
        if ($request->workingTime > 24 || $request->workingTime < 1) {
            $errors[] = __('Nie można pracować więcej niż 24 godziny na dobę, ani krócej niż godzinę:)');
        } else {
            $user->name = $request->name;
            $user->working_time = $request->workingTime;
            $user->save();
        }
        return response()->json( compact('user', 'errors') );
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->employeeId);
        $user->is_active = $request->is_active;
        $user->save();
        return response()->json( compact('user') );
    }

    public function isAdmin()
    {
        $user = auth()->user();
        return $user->is_admin;
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->employees as $key=>$employee) {
            $user = User::find($employee['id']);
            $user->order = $key;
            $user->save();
        }
        $this->getAllUsers(new User());
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function addPresence(Request $request) 
    {
        $presence = new Presence();
        $presence->updateOrCreate([
            'user_id' => $request->userId,
            'date' => Carbon::createFromDate($request->year, $request->month, $request->day)
        ],[]);
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }

    public function addPresences(Request $request) 
    {
        $presence = new Presence();
        foreach($request->days as $day) {
            $date = Carbon::createFromDate($request->year, $request->month, $day);
            $presence->updateOrCreate([
                'user_id' => $request->userId,
                'date' => "$request->year-$request->month-$day"
            ],
            [
                'user_id' => $request->userId,
                'date' => $date
            ]);
        }
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }
  
    public function removePresence(Request $request)
    {
        $presence = new Presence();
        $presence->where('user_id', $request->userId)->whereDate('date', '=', Carbon::createFromDate($request->year, $request->month, $request->day))->delete();
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }

    public function removePresences(Request $request)
    {
        $presence = new Presence();
        foreach($request->days as $day) {
            $presence->where('user_id', $request->userId)->whereDate('date', '=', Carbon::createFromDate($request->year, $request->month, $day))->delete();
        }
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }

    public function getPresences(Request $request)
    {
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        $loggedUser = null;
        $isAdmin = false;
        if (Auth::user()) {
            $loggedUser = Auth::user()->id;
        }
        if (Auth::user() && Auth::user()->is_admin) {
            $isAdmin = true;
        }
        return response()->json( compact('currentMonthObject', 'loggedUser', 'isAdmin'));
    }

    public function buildMonthObject($month, $year) 
    {
        $currentMonthObject = [];
        for ($i=0; $i < cal_days_in_month(CAL_GREGORIAN, $month, $year); $i++) { 
            $day = $i + 1;
            $presence = new Presence();
            $getPresencesForCurrentDay = $presence->whereDate('date', '=', Carbon::createFromDate($year, $month, $day))->get('user_id')->toArray();
            $frequency = [];
            foreach($getPresencesForCurrentDay as $user) {
                $frequency[] = $user['user_id'];
            }
            $currentMonthObject[] = [
                'index' => $i,
                'day' => $day,
                'frequency' => $frequency
            ];
        }
        return $currentMonthObject;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function addPresence(Request $request) 
    {
        $presence = new Presence();
        $presence->create([
            'employee_id' => $request->employeeId,
            'date' => Carbon::createFromDate($request->year, $request->month, $request->day)
        ]);
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }
  
    public function removePresence(Request $request)
    {
        $presence = new Presence();
        $presence->where('employee_id', $request->employeeId)->whereDate('date', '=', Carbon::createFromDate($request->year, $request->month, $request->day))->delete();
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }

    public function getPresences(Request $request)
    {
        $currentMonthObject = $this->buildMonthObject($request->month, $request->year);
        return response()->json( compact('currentMonthObject'));
    }

    public function buildMonthObject($month, $year) 
    {
        $currentMonthObject = [];
        for ($i=0; $i < cal_days_in_month(CAL_GREGORIAN, $month, $year); $i++) { 
            $day = $i + 1;
            $presence = new Presence();
            $getPresencesForCurrentDay = $presence->whereDate('date', '=', Carbon::createFromDate($year, $month, $day))->get('employee_id')->toArray();
            $frequency = [];
            foreach($getPresencesForCurrentDay as $employee) {
                $frequency[] = $employee['employee_id'];
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

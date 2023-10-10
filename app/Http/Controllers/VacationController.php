<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('vacations');
    }

    public function getUserVacations(Request $request)
    {
        $vacations = Vacation::where('user_id', Auth::user()->id)->orderBy('start_date')->get();
        return response()->json( compact('vacations'));
    }

    public function addVacation(Request $request)
    {
        $errors = [];
        $vacation = new Vacation();
        if ($request->startDate <= $request->endDate) {
            $vacations = Vacation::where('user_id', Auth::user()->id)->where('start_date', '<=', $request->endDate)->where('end_date', '>=', $request->startDate)->get();
            if ($vacations->count() == 0) {
                $vacation->user_id = Auth::user()->id;
                $vacation->start_date = $request->startDate;
                $vacation->end_date = $request->endDate;
                $vacation->save();
            } else {
                $errors[] = __('Istnieje juz urlop w podanym terminie.');
            }
            
        } else {
            $errors[] = __('Data końca urlopu nie może być wcześniejsza niż data początku urlopu.');
        }
        $vacations = Vacation::where('user_id', Auth::user()->id)->orderBy('start_date')->get();
        return response()->json( compact('vacations', 'errors'));
    }

    public function getAllUsersVacations(Request $request)
    {
        $vacations = Vacation::where('start_date', '<=', $request->year . '-' . $request->month . '-31')->where('end_date', '>=', $request->year . '-' . $request->month . '-01')->orderBy('start_date')->get();
        $usersVacations = [];
        foreach ($vacations as $vacation) {
            $startDay = $vacation->start_date < Carbon::parse($request->year . '-' . $request->month . '-01') ? 1 : intval(date('d', strtotime($vacation->start_date)));
            $endDay = $vacation->end_date > Carbon::parse($request->year . '-' . $request->month . '-01')->endOfMonth() ? intval(date('t', strtotime($request->year . '-' . $request->month . '-01'))) : intval(date('d', strtotime($vacation->end_date)));
            for ($i = $startDay; $i <= $endDay; $i++) {
                $usersVacations[$vacation->user_id][] = $i;
            }
        }
        return response()->json( compact('usersVacations'));
    }

    public function getVacationCard(Request $request)
    {
        $vacation = Vacation::find($request->id);
        $user = User::find($vacation->user_id);
        $startDate = Carbon::parse($vacation->start_date);
        $endDate = Carbon::parse($vacation->end_date);
        $holidays = $this->getHolidays($startDate->year, $endDate->year);
        $workingDays = $this->countWorkingDays($startDate, $endDate, $holidays);
        $vacationDays = $workingDays - $vacation->days_off;
        $vacationHours = $vacationDays * 8;
        // return view('vacationCard', compact('vacation', 'user', 'workingDays', 'startDate', 'endDate', 'vacationDays', 'vacationHours'));
        $data = [
            'vacation' => $vacation,
            'user' => $user,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'workingDays' => $workingDays,
            'vacationDays' => $vacationDays,
            'vacationHours' => $vacationHours
        ];
        $pdf = Pdf::loadView('vacationCard', $data);
        return $pdf->stream('pdf_file.pdf');
    }

    private function countWorkingDays($startDate, $endDate, $holidays) 
    {
        $begin = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $count = 0;
        foreach ($period as $date) {
            if ($date->format("N") < 6 && !in_array($date->format("Y-m-d"), $holidays)) {
                $count++;
            }
        }
        return $count;
    }

    private function getHolidays($startYear, $endYear) 
    {
        $holidays = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $holidaysApi = "https://date.nager.at/api/v3/PublicHolidays/$year/PL";
            try {
                $holidaysData = file_get_contents($holidaysApi);
                if (false === $holidaysData) {
                    throw new \Exception("Błąd podczas pobierania danych z API dla roku $year");
                }
                $holidaysArray = json_decode($holidaysData, true);
                foreach ($holidaysArray as $holiday) {
                    $holidays[] = $holiday['date'];
                }
            } catch (\Exception $e) {
                echo "Wystąpił błąd: " . $e->getMessage() . "\n";
                // Możesz również zalogować błąd lub podjąć inne kroki, jeśli to konieczne.
            }
        }
        return $holidays;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Presence;

class EmployeeController extends Controller
{
    public function getAllEmployees(Employee $employee)
    {
        $employees = $employee->get();
        return response()->json( compact('employees') );
    }

    public function addEmployee(Request $request) 
    {
        $validate = $request->validate([
            'name' => 'required|string'
        ],[
            'name.required' => 'Imię i nazwisko jest wymagane.'
        ]);

        $employee = Employee::create([
            'name' => $validate['name'],
        ]);
        return response()->json( compact('employee') );
    }

    public function deleteEmployee(Request $request) 
    {
        $employeeId = $request->all()['employeeId'];
        $presences = Presence::where('employee_id', $employeeId)->delete();
        $employee = Employee::where('id', $employeeId)->delete();
        return response()->json( compact('employeeId') );
    }

    public function editEmployee(Request $request) 
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'employeeId' => 'required|exists:App\Models\Employee,id'
        ],[
            'name.required' => 'Imię i nazwisko jest wymagane.'
        ]);
        $employee = Employee::find($validate['employeeId'])->update(['name' => $validate['name']]);
        $employeeId = $validate['employeeId'];
        $name = $validate['name'];
        return response()->json( compact('employeeId', 'name') );
    }
}

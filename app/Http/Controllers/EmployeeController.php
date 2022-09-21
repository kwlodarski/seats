<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function getAllEmployees(Employee $employee)
    {
        $employees = $employee->get();
        return response()->json( compact('employees') );
    }
}

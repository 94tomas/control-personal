<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function createEmployee(Request $request)
    {
        return response()->json($request, 200);
    }
}

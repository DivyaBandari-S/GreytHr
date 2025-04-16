<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegularisationDates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegularisationHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $employeeId = $user->employee_id; // adjust based on your user model

        $history = RegularisationDates::where('employee_id', $employeeId)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Regularisation history fetched successfully.',
            'data' => $history
        ]);
    }
}

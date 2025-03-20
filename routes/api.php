<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeDetailsController;
use App\Http\Controllers\API\EmpPersonalInfoController;
use App\Http\Controllers\API\FeedsController;
use App\Http\Controllers\API\HolidayListController;
use App\Http\Controllers\API\ShowSalaryController;
use App\Http\Controllers\API\SwipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']); // Login with email or emp_id

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'empDetails']);
    Route::get('empdetails', [AuthController::class, 'getEmployeeDetails']); // Fetch Employee Details via Token
    Route::post('allempdetails', [AuthController::class, 'getAllEmployeeDetails']); 
    Route::post('swipe', [SwipeController::class, 'swipe']); // Handle Swipe (Single API for both IN & OUT)
    Route::post('holidays', [HolidayListController::class, 'index']);
    Route::post('/holidays/upcoming', [HolidayListController::class, 'getUpcomingHolidays']);
    // Route::post('/employee/update', [EmployeeDetailsController::class, 'update']);
    Route::post('/employee/show', [EmployeeDetailsController::class, 'show']);
    Route::post('/employee/personal/view', [EmpPersonalInfoController::class, 'show']);
    Route::post('/employee/personal/update', [EmpPersonalInfoController::class, 'update']);
    Route::post('showsal', [ShowSalaryController::class, 'showSalary']);
    Route::post('getfeed', [FeedsController::class, 'getEmployeeFeed']);


});

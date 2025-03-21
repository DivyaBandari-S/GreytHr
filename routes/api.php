<?php

use App\Http\Controllers\API\LeaveApplicationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeDetailsController;
use App\Http\Controllers\API\EmpPersonalInfoController;
use App\Http\Controllers\API\FeedsController;
use App\Http\Controllers\API\HolidayListController;
use App\Http\Controllers\API\ShowSalaryController;
use App\Http\Controllers\API\SwipeController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']); // Login with email or emp_id

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('getEmployeeDetails', [AuthController::class, 'getEmployeeDetails'])->name('getEmployeeDetails');
    Route::post('swipe', [SwipeController::class, 'swipe'])->name('swipe'); // Handle Swipe (Single API for both IN & OUT)
    Route::post('holidays', [HolidayListController::class, 'index'])->name('holidays'); // Handle
    Route::post('/holidays/upcoming', [HolidayListController::class, 'getUpcomingHolidays'])->name('upcomingHolidays'); // Handle
    // Route::post('/employee/update', [EmployeeDetailsController::class, 'update']);
    Route::post('/employee/show', [EmployeeDetailsController::class, 'show'])->name('employee-show');
    Route::post('/employee/personal/view', [EmpPersonalInfoController::class, 'show'])->name('employee-personal-view');
    Route::post('/employee/personal/update', [EmpPersonalInfoController::class, 'update'])->name('employee-personal-update');
    Route::post('showsal', [ShowSalaryController::class, 'showSalary'])->name('showsal');
    Route::post('getfeed', [FeedsController::class, 'getEmployeeFeed'])->name('getfeed');
    Route::get('getBalanceBySelectingLeaveType', [LeaveApplicationsController::class, 'getBalanceBySelectingLeaveType'])->name('getBalanceBySelectingLeaveType');
    Route::get('getApprovedLeaveDays', [LeaveApplicationsController::class, 'getApprovedLeaveDays'])->name('getApprovedLeaveDays');
});

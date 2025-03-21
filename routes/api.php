<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeDetailsController;
use App\Http\Controllers\API\EmpPersonalInfoController;
use App\Http\Controllers\API\HolidayListController;
use App\Http\Controllers\API\ShowSalaryController;
use App\Http\Controllers\API\SwipeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']); // Login with email or emp_id

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('emp-details', [AuthController::class, 'getEmployeeDetails'])->name('emp-details'); // Fetch Employee Details via Token
    Route::post('swipe', [SwipeController::class, 'swipe'])->name('swipe'); // Handle Swipe (Single API for both IN & OUT)
    Route::post('holidays', [HolidayListController::class, 'index'])->name('holidays'); // Handle
    Route::post('holidays/upcoming', [HolidayListController::class, 'getUpcomingHolidays'])->name('holidays-upcoming'); // Handle
    // Route::post('/employee/update', [EmployeeDetailsController::class, 'update']);
    Route::post('employee/show', [EmployeeDetailsController::class, 'show'])->name('employee-show');
    Route::post('employee/personal/view', [EmpPersonalInfoController::class, 'show'])->name('employee-personal-view');
    Route::post('employee/personal/update', [EmpPersonalInfoController::class, 'update'])->name('employee-personal-update');
    Route::post('show-sal', [ShowSalaryController::class, 'showSalary'])->name('show-sal');
});

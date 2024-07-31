<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Livewire\Activities;
use App\Livewire\ApprovedDetails;
use App\Livewire\AddEmployeeDetails;
use App\Livewire\AddHolidayList;
use App\Livewire\ProfileCard;
use App\Livewire\ReviewClosedRegularisation;
use App\Livewire\SickLeaveBalance;
use App\Livewire\UpdateEmployeeDetails;
use App\Livewire\Delegates;
use App\Livewire\EmpLogin;
use App\Livewire\EmployeesReview;
use App\Livewire\Everyone;
use App\Livewire\Feeds;
use App\Livewire\Catalog;

use App\Http\Controllers\GoogleDriveController;
use App\Livewire\Attendance;
use App\Livewire\AuthChecking;
use App\Livewire\GoogleLogins;
use App\Livewire\LeaveCalender;
use App\Livewire\LeaveHistory;
use App\Livewire\LeavePending;
use App\Livewire\Payslip;
use App\Livewire\Regularisation;

use App\Livewire\RegularisationPending;
use App\Livewire\EmployeeSwipes;
use App\Livewire\AttendanceMusterData;
use App\Livewire\AttendanceMuster;
use App\Livewire\AttendenceMasterDataNew;
use App\Livewire\Chat\Chat;
use App\Livewire\EmployeeSwipesData;
use App\Livewire\HelpDesk;
use App\Livewire\Home;
use App\Livewire\Peoples;
use App\Livewire\ProfileInfo;
use App\Livewire\ReviewLeave;
use App\Livewire\ReviewRegularizations;
use App\Livewire\SalaryRevisions;
use App\Livewire\Settings;
use App\Livewire\Review;
use App\Livewire\Tasks;
// use App\Livewire\Loan;
use App\Livewire\Itdeclaration;
use App\Livewire\Itstatement1;
use App\Livewire\Payroll;
use App\Livewire\SalarySlips;
use App\Livewire\PlanA;
use App\Livewire\Documents;
use App\Livewire\Declaration;
use App\Livewire\DocForms;
use App\Livewire\Downloadform;
use App\Livewire\Documentcenter;
use App\Livewire\DocumentCenterLetters;
use App\Livewire\EmpList;
use App\Livewire\Investment;
use App\Livewire\LeaveApply;
use App\Livewire\LeavePage;

// use App\Livewire\SalaryRevisions;
use App\Livewire\Reimbursement;
use App\Livewire\LeaveBalances;
use App\Livewire\WhoIsInChart;
use App\Livewire\LeaveCancel;
use App\Livewire\TeamOnLeave;
use App\Livewire\HolidayCalender;
use App\Livewire\HomeDashboard;
use App\Livewire\LeaveBalanaceAsOnADay;
use App\Livewire\LetterRequests;
use App\Livewire\TeamOnLeaveChart;
use App\Livewire\CasualLeaveBalance;
use App\Livewire\CasualProbationLeaveBalance;
use App\Livewire\Chat\EmployeeList;
use App\Livewire\ViewDetails;
use App\Livewire\ViewDetails1;
use App\Livewire\ListOfAppliedJobs;
use App\Livewire\RegularisationHistory;
use App\Livewire\HrAttendanceOverviewNew;
use App\Livewire\WhoisinChartHr;
use App\Livewire\TeamOnAttendance;
use App\Livewire\TeamOnAttendanceChart;
use App\Livewire\ViewPendingDetails;
use App\Livewire\Emojies;
use App\Livewire\EmployeeAssetsDetails;
use App\Livewire\EmployeeDirectory;
use App\Livewire\EmpTimeSheet;
use App\Livewire\GrantLeaveBalance;
use App\Livewire\ImageUpload;
use App\Livewire\ItDashboardPage;
use App\Livewire\LeaveBalancesChart;
use App\Livewire\LoadingIndicator;
use App\Livewire\OrganisationChart;
use App\Livewire\ReportManagement;
use App\Livewire\ReviewPendingRegularisation;
use App\Livewire\ShiftRoaster;
use App\Livewire\SickLeaveBalances;
use App\Livewire\Test;
use App\Livewire\Ytdreport;
use App\Models\SalaryRevision;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

Route::group(['middleware' => 'checkAuth'], function () {

    Route::get('/emplogin', EmpLogin::class)->name('emplogin');
    Route::get('/CompanyLogin', function () {
        return view('company_login_view');
    });


    Route::get('/login', [GoogleLogins::class, 'redirectToGoogle'])->name('login');
    Route::get('/auth/google/callback', [GoogleLogins::class, 'handleGoogleCallback'])->name('auth/google/callback');
    Route::get('/Jobs', function () {
        return view('jobs_view');
    });
    Route::get('/CreateCV', function () {
        return view('create_cv_view');
    });
});

Route::get('/Login&Register', function () {
    return view('login_and_register_view');
});

Route::middleware(['auth:web', 'handleSession'])->group(function () {
    Route::get('/CreateCV', function () {
        return view('create_cv_view');
    });
    Route::get('/Jobs', function () {
        return view('jobs_view');
    });


    Route::get('/AllNotifications', function () {
        return view('all-notifications_view');
    });
    Route::get('/NotificationList{jobId}', function ($jobId) {
        return view('notification_list_view', compact('jobId'));
    })->name('job-interview-details');

    Route::get('/UserProfile', function () {
        return view('user_profile_view');
    });
    Route::get('/full-job-view/{jobId}', function ($jobId) {
        return view('full_job_details_view', compact('jobId'));
    })->name('full-job-view');

    Route::get('/AppliedJobs', function () {
        return view('applied_jobs_view');
    });
    Route::get('/list-of-applied-jobs', ListOfAppliedJobs::class)->name('list-of-applied-jobs');
    Route::get('/Companies', function () {
        return view('companies_view');
    });
    Route::get('/company-based-jobs/{companyId}', function ($companyId) {
        return view('company_based_jobs_view', compact('companyId'));
    })->name('company-based-jobs');
    Route::get('/VendorScreen', function () {
        return view('vendor_screen_view');
    });
});



Route::middleware(['auth:com', 'handleSession'])->group(function () {
    Route::get('/PostJobs', function () {
        return view('post_jobs_view');
    });


    Route::get('/VendorsSubmittedCVs', function () {
        return view('vendors-submitted-cvs');
    });
    Route::get('/JobSeekersAppliedJobs', function () {
        return view('job-seekers-applied-jobs');
    });

    Route::get('/empregister', function () {
        return view('emp-register-view');
    });
    // Route::get('/emplist', EmpList::class)->name('emplist');
    Route::get('/emplist', function () {
        return view('emp-list-view');
    });

    Route::get('/emp-update/{empId}', function ($empId) {
        return view('emp-update-view', compact('empId'));
    })->name('emp-update');
});

Route::middleware(['auth:hr', 'handleSession'])->group(function () {
    Route::get('/hrFeeds', Feeds::class)->name('hrfeeds');
    Route::get('/hreveryone', Everyone::class)->name('hreveryone');
    Route::get('/hrevents', Activities::class);
    Route::get('/hrPage', AuthChecking::class)->name('hrPage');
    Route::get('/home-dashboard', HomeDashboard::class)->name('admin-home');
    Route::get('/letter-requests', LetterRequests::class)->name('letter-requests');
    Route::get('/add-employee-details/{employee?}', AddEmployeeDetails::class)->name('add-employee-details');
    Route::get('/update-employee-details', UpdateEmployeeDetails::class)->name('update-employee-details');
    Route::get('/whoisinhrchart', WhoisinChartHr::class)->name('whoisinhrchart');
    // Route::get('/hrleaveOverview', HrLeaveOverview::class)->name('hrleaveOverview');
    Route::get('/hrAttendanceOverview', HrAttendanceOverviewNew::class)->name('hrAttendanceOverview');
    Route::get('/addLeaves', GrantLeaveBalance::class)->name('leave-grant');
    // Route::get('/hremployeedirectory', EmployeeDirectory::class)->name('employee-directory');
    Route::get('/hrorganisationchart', OrganisationChart::class)->name('organisation-chart');
    Route::get('/add-holiday-list', AddHolidayList::class)->name('holiday-list');
    // Route::get('/linechart', LineChart::class)->name('linechart');
});

Route::middleware(['auth:finance', 'handleSession'])->group(function () {
    Route::get('/financePage', AuthChecking::class)->name('financePage');
});

Route::middleware(['auth:it', 'handleSession'])->group(function () {
    Route::get('/itPage', AuthChecking::class)->name('IT-requests');
    Route::get('/emp-assets-details', EmployeeAssetsDetails::class)->name('employee-asset-details');
    Route::get('/ithomepage', ItDashboardPage::class)->name('ithomepage');
});

Route::middleware(['auth:admins', 'handleSession'])->group(function () {
    Route::get('/adminPage', AuthChecking::class)->name('auth-checking');
});


Route::middleware(['auth:emp', 'handleSession'])->group(function () {
    Route::get('/google-redirect', [GoogleDriveController::class, 'auth'])
        ->name('google-redirect');
    Route::get('/google-callback', [GoogleDriveController::class, 'callback'])
        ->name('google-callback');

    Route::get('/', Home::class)->name('home');
    Route::get('/doc-forms', DocForms::class);
    Route::get('/LeaveBalanceAsOnADay', LeaveBalanaceAsOnADay::class);

    // Attendance Routes
    Route::get('/Attendance', Attendance::class)->name('Attendance info');
    Route::get('/whoisinchart', WhoIsInChart::class)->name('whoisin');
    Route::get('/regularisation', Regularisation::class)->name('regularisation');
    Route::get('/regularisation-pending/{id}', RegularisationPending::class)->name('regularisation-pending');
    Route::get('/regularisation-history/{id}', RegularisationHistory::class)->name('regularisation-history');
    Route::get('/employee-swipes', EmployeeSwipes::class)->name('employee-swipes');
    Route::get('/employee-swipes-data', EmployeeSwipesData::class)->name('employee-swipes-data');
    Route::get('/attendance-muster', AttendanceMuster::class)->name('attendance-muster');
    Route::get('/attendance-muster-data', AttendenceMasterDataNew::class)->name('attendance-muster-data');
    Route::get('/shift-roaster-data', ShiftRoaster::class)->name('shift-roaster-data');
    Route::get('/ProfileInfo', ProfileInfo::class)->name('profile.info');
    Route::get('/ProfileCard', ProfileCard::class)->name('profile');
    Route::get('/Settings', Settings::class)->name('settings');
    Route::get('/review-pending-regularation/{id}', ReviewPendingRegularisation::class)->name('review-pending-regularation');
    Route::get('/review-closed-regularation/{id}', ReviewClosedRegularisation::class)->name('review-closed-regularation');
    Route::get('/time-sheet', EmpTimeSheet::class)->name('time-sheet');


    //Feeds Module
    Route::get('/Feeds', Feeds::class)->name('feeds');
    Route::get('/events', Activities::class);
    Route::get('/everyone', Everyone::class);

    //People module
    Route::get('/PeoplesList', Peoples::class)->name('people');


    //Helpdesk module

    Route::get('/HelpDesk', HelpDesk::class)->name('helpdesk');

    Route::get('/catalog', Catalog::class)->name('catalog');

    // Related salary module and ITdeclaration Document center
    Route::get('/payslip', Payroll::class);
    Route::get('/slip', SalarySlips::class)->name('payslips');
    Route::get('/itdeclaration', Itdeclaration::class)->name('itdeclaration');
    Route::get('/itstatement', Itstatement1::class)->name('IT-Statement');
    Route::get('/plan-A', PlanA::class)->name('plan-a');
    Route::get('/document-center-letters', DocumentCenterLetters::class);
    Route::get('/delegates', Delegates::class)->name('work-flow-delegates');
    Route::get('/salary-revision', SalaryRevisions::class)->name('salary-revision');
    Route::get('/plan-C', PlanA::class)->name('plan-c');
    Route::get('/formdeclaration', Declaration::class)->name('IT-Declaration');
    Route::get('/document', Documentcenter::class)->name('Document-center');
    Route::get('/reimbursement', Reimbursement::class)->name('reimbursement');
    Route::get('/investment', Investment::class)->name('proof-of-investment');
    Route::get('/documents', Documents::class);
    Route::get('/ytd', Ytdreport::class)->name('ytdreport');


    //leave module
    Route::get('/leave-page', LeavePage::class)->name('leave-page');
    Route::get('/approved-details/{leaveRequestId}', ApprovedDetails::class)->name('approved-details');
    Route::get('/view-details/{leaveRequestId}', ViewDetails::class)->name('view-details');
    Route::get('/view-pending-details', ViewDetails::class)->name('pending-details');
    Route::get('/leave-apply', LeaveApply::class);
    Route::get('/holiday-calendar', HolidayCalender::class)->name('holiday-calendar');
    Route::get('/leave-balances', LeaveBalances::class)->name('leave-balance');
    Route::get('/casualleavebalance', CasualLeaveBalance::class)->name('casual-leave-balance');
    Route::get('/sickleavebalance', SickLeaveBalances::class)->name('sick-leave-balance');
    Route::get('/casualprobationleavebalance', CasualProbationLeaveBalance::class)->name('casual-probation-leave-balance');
    Route::get('/leave-cancel', LeaveCancel::class)->name('lseave-cancel');
    Route::get('/leave-calender', LeaveCalender::class)->name('leave-calendar');
    Route::get('/leave-history/{leaveRequestId}', LeaveHistory::class)->name('leave-history');
    Route::get('/leave-pending/{leaveRequestId}', LeavePending::class)->name('leave-pending');
    Route::get('/team-on-leave', TeamOnLeave::class);
    Route::get('/team-on-leave-chart', TeamOnLeaveChart::class)->name('team-on-leave');
    Route::get('/testing', Test::class);
    // Route::get('/leaveBalChart', LeaveBalancesChart::class)->name('leave-details');
    // Route::get('/navigate-to-helpdesk', [EmployeesReview::class, 'navigateToHelpdesk'])->name('navigate.to.helpdesk');

    // TODO module
    Route::get('/tasks', Tasks::class)->name('tasks');
    Route::get('/employees-review', EmployeesReview::class)->name('review');
    Route::get('/reports', ReportManagement::class)->name('reports');
    Route::get('/review-regularizations', ReviewRegularizations::class)->name('regularizations');

    // ####################################### Chat Module Routes #########################endregion
    // Route::get('/chat',Index::class)->name('chat.index');
    Route::get('/chat/{query}',Chat::class)->name('chat');
    Route::get('/users',EmployeeList::class)->name('employee');
    Route::get('/image',ImageUpload::class)->name('image');
    Route::get('/loader',LoadingIndicator::class)->name('loader');
    //*******************************************  End Of Chat Module Routes *************************/
});





Route::get('/itform', function () {
    return view('itform');
});
//Download routes
Route::get('/your-download-route', function () {
    return view('download-pdf');
});
Route::get('/downloadform', function () {
    return view('downloadform');
});

Route::get('/attune-reports', function () {
    return view('mail-content_view');
});

Route::get('/data-entry', function () {
    return view('data-entry_view');
});
Route::get('/ytdpayslip', function () {
    return view('ytdpayslip');
});









use App\Models\EmpSalary;

Route::get('/encode/{value}', function ($value) {
    // Determine the number of decimal places
    $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;

    // Convert the float to an integer with precision
    $factor = pow(10, $decimalPlaces);
    $integerValue = intval($value * $factor);

    // Encode the integer value along with the decimal places
    $hash = Hashids::encode($integerValue, $decimalPlaces);

    return response()->json([
        'value' => $value,
        'hash' => $hash,
        // 'decimalPlaces' => $decimalPlaces
    ]);
});



Route::get('/decode/{hash}', function ($hash) {
    // Decode the hash
    $decoded = Hashids::decode($hash);

    // Check if decoding was successful
    if (count($decoded) === 0) {
        return response()->json(['error' => 'Invalid hash'], 400);
    }

    // Retrieve the integer value and decimal places
    $integerValue = $decoded[0];
    $decimalPlaces = $decoded[1] ?? 0; // Fallback to 0 if not present

    // Convert back to float
    $originalValue = $integerValue / pow(10, $decimalPlaces);

    return response()->json([
        'hash' => $hash,
        'value' => $originalValue
    ]);
});



Route::get('/salary/{emp_id}', function ($emp_id) {
    $empSalary = EmpSalary::findOrFail($emp_id);
    dd($empSalary);
    // Return the salary attribute
    return response()->json([
        'emp_id' => $empSalary->emp_id,
        'salary' => $empSalary->salary, // This will automatically call the getSalaryAttribute method
        'effective_date' => $empSalary->effective_date,
        'remarks' => $empSalary->remarks,
    ]);
});

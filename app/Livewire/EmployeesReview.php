<?php
// File Name                       : EmployeesReview.php
// Description                     : This file contains the implementation of Approving leave, attendance request applied by team memebers, Manager can review leave & attendance applications which are applied by team
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails -->
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularisationNew;
use App\Models\RegularisationNew1;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EmployeesReview extends Component
{

 public function render(){
    return view('livewire.employees-review');
 }
}

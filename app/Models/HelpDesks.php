<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpDesks extends Model
{
    use HasFactory;
    protected $fillable=[
        'emp_id', 'category', 'subject', 'description', 'file_path', 'cc_to', 'priority','status','mail','mobile','distributor_name','selected_equipment'
     ];
    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public static function getCategories()
    {
        return [
            'HR' => [
              
                'Employee Information',
                'Hardware Maintenance',
                'Incident Report',
                'Privilege Access Request',
                'Security Access Request',
                'Technical Support'
            ],
            'Finance' => [
             
                'Income Tax',
                'Loans',
                'Payslip'
            ],
            'IT' => [
               
                'Employee Information',
                'Hardware Maintenance',
                'Incident Report',
                'Privilege Access Request',
                'Security Access Request',
                'Technical Support',
                'Request For IT',
                'Distribution List Request',
                'New Laptop',
                'New Distribution Request',
                'New Mailbox Request',
                'Devops Access Request',
                'New ID Card',
                'MMS Request',
                'Desktop Request'
            ]
        ];
    }
}
    
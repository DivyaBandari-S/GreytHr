<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Log;
class EmpSalaryRevision extends Model
{
    use HasFactory;
    protected $table = 'salary_revisions'; // Set the table name if it's not the default "salary_revisions"

    // protected $primaryKey = 'emp_id'; // Set the primary key if it's not "id"

    // public $incrementing = false; // Set to false to indicate that "emp_id" is not auto-incrementing

    // protected $keyType = 'string'; // Set the data type for the primary key

    protected $fillable = [
        'emp_id',
        'current_ctc',
        'revised_ctc',
        'revision_date',
        'revision_type',
        'reason',
        'status'
    ];

  /**
     * Set the current CTC attribute and encode it before saving.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setCurrentCtcAttribute($value)
    {
        // Determine the number of decimal places dynamically
        $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;

        // Convert the float to an integer representation
        $factor = pow(10, $decimalPlaces);
        $integerValue = intval($value * $factor);

        // Encode the integer value and decimal places
        $this->attributes['current_ctc'] = Hashids::encode($integerValue, $decimalPlaces);
    }

    /**
     * Get the current CTC attribute and decode it when retrieving.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getCurrentCtcAttribute($value)
    {
        Log::info('Decoding current CTC: ' . $value);

        // Decode the hash
        $decoded = Hashids::decode($value);

        // Check if decoding was successful
        if (count($decoded) === 0) {
            return null;
        }

        // Retrieve the integer value and decimal places
        $integerValue = $decoded[0];
        $decimalPlaces = $decoded[1] ?? 0; // Default to 0 if not present

        // Convert back to float
        return $integerValue / pow(10, $decimalPlaces);
    }

    /**
     * Set the revised CTC attribute and encode it before saving.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setRevisedCtcAttribute($value)
    {
        // Determine the number of decimal places dynamically
        $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;

        // Convert the float to an integer representation
        $factor = pow(10, $decimalPlaces);
        $integerValue = intval($value * $factor);

        // Encode the integer value and decimal places
        $this->attributes['revised_ctc'] = Hashids::encode($integerValue, $decimalPlaces);
    }

    /**
     * Get the revised CTC attribute and decode it when retrieving.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getRevisedCtcAttribute($value)
    {
        Log::info('Decoding revised CTC: ' . $value);

        // Decode the hash
        $decoded = Hashids::decode($value);

        // Check if decoding was successful
        if (count($decoded) === 0) {
            return null;
        }

        // Retrieve the integer value and decimal places
        $integerValue = $decoded[0];
        $decimalPlaces = $decoded[1] ?? 0; // Default to 0 if not present

        // Convert back to float
        return $integerValue / pow(10, $decimalPlaces);
    }
    protected $appends = ['basic', 'hra', 'medical', 'special', 'conveyance', 'pf'];

    public function getBasicAttribute()
    {
        return $this->calculateBasic();
    }

    public function getHraAttribute()
    {
        return $this->calculateHRA();
    }

    public function getMedicalAttribute()
    {
        return $this->calculateMedical();
    }

    public function getSpecialAttribute()
    {
        return $this->calculateSpecial();
    }

    public function getConveyanceAttribute()
    {
        return 1600; // Fixed amount for conveyance
    }

    public function calculateBasic()
    {
        return ($this->salary * 0.4); // 40% of the salary as Basic
    }

    public function calculateHRA()
    {
        return ($this->basic * 0.4); // 40% of basic as HRA
    }

    public function calculateMedical()
    {
        return 1250; // Fixed amount for Medical Allowance
    }

    public function calculateSpecial()
    {
        $remainingSalary = $this->salary - ($this->basic + $this->hra + $this->conveyance + $this->medical + $this->calculatePf());
        return max($remainingSalary, 0); // Fixed amount for Special Allowance
    }

    public function calculatePf()
    {
        $basic = $this->calculateBasic();
        if ($basic) {
            // Calculate PF as 12% of Basic
            return ($basic * 0.12);
        } else {
            // If Basic is not set, PF is 0
            return 0;
        }
    }
    public function calculateEsi()
    {
        $basic = $this->calculateBasic();
        if ($basic) {
            // Calculate PF as 12% of Basic
            return ($basic * 0.0075);
        } else {
            // If Basic is not set, PF is 0
            return 0;
        }
    }

    public function calculateProfTax()
    {
        return 150; // Fixed amount for Medical Allowance
    }
    public function calculateTotalDeductions()
    {
        return $this->calculatePf() + $this->calculateEsi() + $this->calculateProfTax();
    }

    public function getEmployeeByEmpId($emp_id)
    {
        return $this->where('emp_id', $emp_id)->first();
    }




    public function calculateTotalAllowance()
    {
        return $this->basic + $this->hra + $this->conveyance + $this->medical + $this->special;
    }

    // Override the booted method to perform operations when the model is retrieved from the database



    // Define the relationship to the Employee model
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
}

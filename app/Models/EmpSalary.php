<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Log;

class EmpSalary extends Model
{
    use HasFactory;

    protected $fillable = ['sal_id', 'salary', 'effective_date', 'remarks'];
    protected $appends = ['basic', 'hra', 'medical', 'special', 'conveyance', 'pf'];

    private $decodedSalary = null; // Cache decoded salary for repeated calculations

    /**
     * Set and encode salary before saving.
     */
    public function setSalaryAttribute($value)
    {
        $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;
        $factor = pow(10, $decimalPlaces);
        $this->attributes['salary'] = Hashids::encode(intval($value * $factor), $decimalPlaces);
    }

    /**
     * Decode salary for calculations and cache the result.
     */
    public function getDecodedSalary()
    {
        if ($this->decodedSalary === null) {
            $decoded = Hashids::decode($this->attributes['salary']);
            if (count($decoded) === 0) {
                // If decoding fails, return 0
                $this->decodedSalary = 0;
            } else {
                $integerValue = $decoded[0];
                $decimalPlaces = $decoded[1] ?? 0;
                $this->decodedSalary = $integerValue / pow(10, $decimalPlaces);
            }
        }
        return $this->decodedSalary;
    }

    /**
     * Define relationship with EmpSalaryRevision.
     */
    public function salaryRevision()
    {
        return $this->belongsTo(EmpSalaryRevision::class, 'sal_id');
    }

    /**
     * Salary breakdown attributes.
     */
    public function getBasicAttribute()
    {
        return $this->getDecodedSalary() > 0 ? $this->calculatePercentageOfSalary(0.4) : 0;
    }

    public function getHraAttribute()
    {
        return $this->basic > 0 ? $this->basic * 0.4 : 0;
    }

    public function getMedicalAttribute()
    {
        return 1250;
    }

    public function getConveyanceAttribute()
    {
        return 1600;
    }

    public function getSpecialAttribute()
    {
        $totalDeductions = $this->basic + $this->hra + $this->conveyance + $this->medical + $this->pf;
        return $this->getDecodedSalary() > 0 ? max($this->getDecodedSalary() - $totalDeductions, 0) : 0;
    }

    public function getPfAttribute()
    {
        return $this->basic > 0 ? $this->calculatePercentageOfBasic(0.12) : 0;
    }

    public function calculateEsi()
    {
        return $this->basic > 0 ? $this->calculatePercentageOfBasic(0.0075) : 0;
    }

    public function calculateProfTax()
    {
        return 150;
    }

    public function calculateTotalDeductions()
    {
        return $this->pf + $this->calculateEsi() + $this->calculateProfTax();
    }

    public function calculateTotalAllowance()
    {
        return $this->basic + $this->hra + $this->conveyance + $this->medical + $this->special;
    }

    /**
     * Helper methods.
     */
    private function calculatePercentageOfSalary($percentage)
    {
        return $this->getDecodedSalary() > 0 ? $this->getDecodedSalary() * $percentage : 0;
    }

    private function calculatePercentageOfBasic($percentage)
    {
        return $this->basic > 0 ? $this->basic * $percentage : 0;
    }

    /**
     * Get employee salary by employee ID.
     */
    public function getEmployeeByEmpId($emp_id)
    {
        return $this->where('emp_id', $emp_id)->first();
    }
}

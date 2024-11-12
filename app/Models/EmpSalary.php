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
            if (count($decoded) === 0) return null;

            $integerValue = $decoded[0];
            $decimalPlaces = $decoded[1] ?? 0;
            $this->decodedSalary = $integerValue / pow(10, $decimalPlaces);
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
        return $this->calculatePercentageOfSalary(0.4);
    }

    public function getHraAttribute()
    {
        return $this->basic * 0.4;
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
        return max($this->getDecodedSalary() - $totalDeductions, 0);
    }

    public function getPfAttribute()
    {
        return $this->calculatePercentageOfBasic(0.12);
    }

    public function calculateEsi()
    {
        return $this->calculatePercentageOfBasic(0.0075);
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
        return $this->getDecodedSalary() * $percentage;
    }

    private function calculatePercentageOfBasic($percentage)
    {
        return $this->basic * $percentage;
    }

    public function getEmployeeByEmpId($emp_id)
    {
        return $this->where('emp_id', $emp_id)->first();
    }
}

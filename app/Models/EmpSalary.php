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

    /**
     * Set the salary attribute and encode it before saving.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setSalaryAttribute($value)
    {
        $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;
        $factor = pow(10, $decimalPlaces);
        $integerValue = intval($value * $factor);

        $this->attributes['salary'] = Hashids::encode($integerValue, $decimalPlaces);
    }

    /**
     * Get the salary attribute and decode it when retrieving.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getSalaryAttribute($value)
    {
        Log::info('Decoding salary: ' . $value);

        $decoded = Hashids::decode($value);

        if (count($decoded) === 0) {
            return null;
        }

        $integerValue = $decoded[0];
        $decimalPlaces = $decoded[1] ?? 0;

        return $integerValue / pow(10, $decimalPlaces);
    }

    /**
     * Define relationship with EmpSalaryRevision.
     */
    public function salaryRevision()
    {
        return $this->belongsTo(EmpSalaryRevision::class, 'sal_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SwipeRecord extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['emp_id', 'swipe_time', 'in_or_out', 'is_regularized', 'sign_in_device','device_name','device_id'];
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public function getSwipeRecordsTables()
    {
        $tablePrefix = 'swipe_records_';
        $tables = DB::select("SHOW TABLES LIKE '{$tablePrefix}%'");
        return array_map(fn($table) => array_values((array) $table)[0], $tables);
    }
    public function getAllSwipeRecords()
    {
        $data = [];
        $tables = $this->getSwipeRecordsTables();

        foreach ($tables as $table) {
            $data = array_merge($data, DB::table($table)->get()->toArray());
        }

        return $data;
    }
}

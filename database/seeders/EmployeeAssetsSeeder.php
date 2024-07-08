<?php

namespace Database\Seeders;

use App\Models\EmployeeAsset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EmployeeAssets;
use App\Models\EmployeeDetails;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columnNames = Schema::getColumnListing('employee_assets');
        $columnTypes = [];
        foreach ($columnNames as $columnName) {
            $columnTypes[$columnName] = Schema::getColumnType('employee_assets', $columnName);
        }

        // Generate dummy data
        $existingEmpId = EmployeeDetails::pluck('emp_id')->random();
        // Generate dummy data
        $dummyData = [
            'emp_id' => $existingEmpId,
        ];
        foreach ($columnTypes as $columnName => $columnType) {
            switch ($columnType) { // Use $columnType directly
                case 'date':
                    // For date fields, use a random date within a reasonable range
                    $dummyData[$columnName] = Carbon::now()->subDays(rand(0, 365))->toDateString();
                    break;
                case 'integer':
                    // For integer fields, use a random integer value
                    $dummyData[$columnName] = rand(1, 100);
                    break;
                case 'decimal':
                    // For decimal fields, use a random decimal value
                    $dummyData[$columnName] = rand(100, 10000) / 100;
                    break;
                case 'text':
                    // For text fields, generate random dummy text
                    $dummyData[$columnName] = $this->generateRandomText();
                    break;
                case 'string':
                    // For string fields, use a dummy string value
                    $dummyData[$columnName] = 'Dummy Value';
                    break;
                default:
                    // For other field types, use a placeholder
                    $dummyData[$columnName] = null;
                    break;
            }
        }

        // Add created_at and updated_at timestamps
        $dummyData['created_at'] = now();
        $dummyData['updated_at'] = now();

        // Insert dummy data
        EmployeeAsset::create($dummyData);
    }
    private function generateRandomText($length = 100): string
    {
        // Characters to use in generating random text
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $text = '';

        // Generate random text of specified length
        for ($i = 0; $i < $length; $i++) {
            $text .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $text;
    }
}

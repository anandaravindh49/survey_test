<?php

namespace App\Console\Commands;

use App\Models\BusinessArea;
use Illuminate\Console\Command;

class RestoreBusinessAreas extends Command
{
    protected $signature = 'app:restore-business-areas';
    protected $description = 'Restore Business Areas data';

    public function handle()
    {
        $data = [
            ['Package 1', 'Maharashtra', 'Business Area 1', 'BA001', 'ACTIVE'],
            ['Package 2', 'Gujarat', 'Business Area 2', 'BA002', 'ACTIVE'],
            ['Package 3', 'Rajasthan', 'Business Area 3', 'BA003', 'ACTIVE'],
            ['Package 4', 'Karnataka', 'Business Area 4', 'BA004', 'ACTIVE'],
            ['Package 4', 'Pondichery', 'Business Area 5', 'BA005', 'ACTIVE'],
            ['Package 4', 'Goa', 'Business Area 6', 'BA006', 'ACTIVE'],
            ['Package 5', 'Uttar Pradesh', 'Business Area 7', 'BA007', 'ACTIVE'],
            ['Package 6', 'Haryana', 'Business Area 8', 'BA008', 'ACTIVE'],
            ['Package 7', 'Bihar', 'Business Area 9', 'BA009', 'ACTIVE'],
            ['Package 8', 'Jharkhand', 'Business Area 10', 'BA010', 'ACTIVE'],
            ['Package 9', 'Madhya Pradesh', 'Business Area 11', 'BA011', 'ACTIVE'],
            ['Package 10', 'Tamil Nadu', 'Business Area 12', 'BA012', 'ACTIVE'],
            ['Package 11', 'Telangana', 'Business Area 13', 'BA013', 'ACTIVE'],
            ['Package 12', 'West Bengal', 'Business Area 14', 'BA014', 'ACTIVE'],
            ['Package 13', 'Jammu & Kashmir', 'Business Area 15', 'BA015', 'ACTIVE'],
            ['Package 13', 'Ladakh', 'Business Area 16', 'BA016', 'ACTIVE'],
            ['Package 1', 'Delhi', 'Business Area 17', 'BA017', 'ACTIVE'],
        ];

        foreach ($data as $item) {
            BusinessArea::create([
                'package_name' => $item[0],
                'state_name' => $item[1],
                'business_name' => $item[2],
                'code' => $item[3],
                'status' => $item[4],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $count = BusinessArea::count();
        $this->info("✅ Business Areas restored! Total: $count");
    }
}

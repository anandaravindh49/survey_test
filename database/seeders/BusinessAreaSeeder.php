<?php

namespace Database\Seeders;

use App\Models\BusinessArea;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BusinessAreaSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = '/home/azotos/Downloads/business-areas.xlsx';

        if (!file_exists($filePath)) {
            $this->command->warn("Excel file not found at {$filePath}");
            return;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headers = [];
            $rows = $worksheet->toArray();

            // Get headers from first row
            if (count($rows) > 0) {
                $headers = array_map('trim', $rows[0]);
            }

            // Process data rows (skip header)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    BusinessArea::create([
                        'package_name' => isset($row[0]) ? trim($row[0]) : '',
                        'state_name' => isset($row[1]) ? trim($row[1]) : '',
                        'business_name' => isset($row[2]) ? trim($row[2]) : '',
                        'code' => isset($row[3]) ? trim($row[3]) : '',
                        'status' => 'ACTIVE',
                        'created_by' => null,
                        'updated_by' => null,
                    ]);
                } catch (\Exception $e) {
                    $this->command->warn("Row " . ($i + 1) . " skipped: " . $e->getMessage());
                    continue;
                }
            }

            $this->command->info('Business Areas seeded successfully!');
        } catch (\Exception $e) {
            $this->command->error('Error reading Excel file: ' . $e->getMessage());
        }
    }
}

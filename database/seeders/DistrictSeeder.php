<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = '/home/azotos/Downloads/district.xlsx';

        if (!file_exists($filePath)) {
            $this->command->error("File not found: {$filePath}");
            return;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $rowCount = 0;
            $duplicates = 0;
            foreach ($worksheet->getRowIterator(2) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }

                if (count($cells) >= 5 && !empty($cells[0])) {
                    $code = (string)($cells[4] ?? '');
                    
                    // Check if district with this code already exists
                    if (District::where('code', $code)->exists()) {
                        $duplicates++;
                        continue;
                    }

                    District::create([
                        'package_name' => $cells[0] ?? 'N/A',
                        'state_name' => $cells[1] ?? 'N/A',
                        'business_area' => $cells[2] ?? 'N/A',
                        'district_name' => $cells[3] ?? 'N/A',
                        'code' => $code,
                        'status' => 'ACTIVE',
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);

                    $rowCount++;
                }
            }

            $this->command->info("Successfully seeded {$rowCount} districts from Excel file.");
            if ($duplicates > 0) {
                $this->command->warn("Skipped {$duplicates} duplicate records.");
            }
        } catch (\Exception $e) {
            $this->command->error("Error reading Excel file: " . $e->getMessage());
        }
    }
}

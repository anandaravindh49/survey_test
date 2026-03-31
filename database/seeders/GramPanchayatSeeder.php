<?php

namespace Database\Seeders;

use App\Models\GramPanchayat;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GramPanchayatSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = '/home/azotos/Downloads/Karnataka_gp_master_data.xlsx';

        if (!file_exists($filePath)) {
            $this->command->error("File not found: {$filePath}");
            return;
        }

        try {
            // Truncate existing records
            GramPanchayat::truncate();

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $rowCount = 0;
            $duplicates = 0;

            foreach ($worksheet->getRowIterator() as $row) {
                // Skip header rows (row 1 is title, row 2 is headers)
                if ($row->getRowIndex() <= 2) continue;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Skip empty rows
                if (empty($data[1])) break;

                // Excel columns: SL.NO, STATE, BUSINESS AREA, DISTRICT, BLOCK, GP NAME, GP CODE, GP TYPE
                $state = $data[1] ?? null;           // STATE (B)
                $businessArea = $data[2] ?? null;    // BUSINESS AREA (C)
                $district = $data[3] ?? null;        // DISTRICT (D)
                $block = $data[4] ?? null;           // BLOCK (E)
                $gpName = $data[5] ?? null;          // GP NAME (F)
                $gpCode = $data[6] ?? null;          // GP CODE (G)
                $gpType = $data[7] ?? null;          // GP TYPE (H)

                $existingGP = GramPanchayat::where('gp_code', $gpCode)->first();

                if (!$existingGP) {
                    GramPanchayat::create([
                        'state_name' => $state,
                        'business_area' => $businessArea,
                        'district_name' => $district,
                        'block_name' => $block,
                        'gp_name' => $gpName,
                        'gp_code' => $gpCode,
                        'gp_type' => $gpType,
                        'status' => 'ACTIVE',
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                    $rowCount++;
                } else {
                    $duplicates++;
                }
            }

            $this->command->info("Gram Panchayats imported: {$rowCount}, Duplicates skipped: {$duplicates}");
        } catch (\Exception $e) {
            $this->command->error("Error importing Gram Panchayats: " . $e->getMessage());
        }
    }
}

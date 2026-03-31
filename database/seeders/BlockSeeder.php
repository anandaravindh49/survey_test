<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = '/home/azotos/Downloads/block.xlsx';

        if (!file_exists($filePath)) {
            $this->command->error("File not found: {$filePath}");
            return;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $rowCount = 0;
            $duplicates = 0;

            foreach ($worksheet->getRowIterator() as $row) {
                if ($row->getRowIndex() === 1) continue; // Skip header

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                if (empty($data[0])) break;

                $package = $data[0] ?? null;
                $state = $data[1] ?? null;
                $businessArea = $data[2] ?? null;
                $district = $data[3] ?? null;
                $blockName = $data[4] ?? null;
                $code = $data[5] ?? null;
                $status = $data[6] ?? 'ACTIVE';

                $existingBlock = Block::where('code', $code)->first();

                if (!$existingBlock) {
                    Block::create([
                        'package_name' => $package,
                        'state_name' => $state,
                        'business_area' => $businessArea,
                        'district_name' => $district,
                        'block_name' => $blockName,
                        'code' => $code,
                        'status' => $status,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);

                    $rowCount++;
                } else {
                    $duplicates++;
                }
            }

            $this->command->info("Blocks imported: {$rowCount}, Duplicates skipped: {$duplicates}");
        } catch (\Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}

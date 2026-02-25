<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = '/home/azotos/Downloads/Machines_karnataka_20260224_132140.xlsx';

        if (!file_exists($filePath)) {
            $this->command->error("File not found: {$filePath}");
            return;
        }

        try {
            // Truncate existing records
            Machine::truncate();

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

                // Excel columns: Make, Serial No, Operator Name, Operator Id, Machine State, UUID, Created On
                $make = $data[0] ?? null;          // Make (A)
                $serialNo = $data[1] ?? null;      // Serial No (B)
                $operatorName = $data[2] ?? null;  // Operator Name (C)
                $operatorId = $data[3] ?? null;    // Operator Id (D)
                $state = $data[4] ?? null;         // Machine State (E)
                $uuid = $data[5] ?? null;          // UUID (F)
                
                // Use UUID as unique code (extract UUID from URL)
                $code = $uuid ? basename($uuid) : ($serialNo ?? uniqid());

                $existingMachine = Machine::where('code', $code)->first();

                if (!$existingMachine) {
                    Machine::create([
                        'package_name' => 'Karnataka',
                        'state_name' => $state,
                        'business_area' => null,
                        'district_name' => null,
                        'block_name' => null,
                        'machine_name' => $make,
                        'machine_type' => $serialNo,
                        'code' => $code,
                        'status' => 'ACTIVE',
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                    $rowCount++;
                } else {
                    $duplicates++;
                }
            }

            $this->command->info("Machines imported: {$rowCount}, Duplicates skipped: {$duplicates}");
        } catch (\Exception $e) {
            $this->command->error("Error importing machines: " . $e->getMessage());
        }
    }
}

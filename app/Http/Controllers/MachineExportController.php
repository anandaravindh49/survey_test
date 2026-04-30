<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MachineExportController extends Controller
{
    public function export()
    {
        $fileName = 'machines-' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            // header row
            fputcsv($out, [
                'id','package_name','machine_state','business_area','machine_district','machine_block','make','serial_no','operator_name','mobile','operator_id','machine_type','code','status','created_at','updated_at'
            ]);

            foreach (Machine::cursor() as $m) {
                fputcsv($out, [
                    $m->id,
                    $m->package_name,
                    $m->machine_state,
                    $m->business_area,
                    $m->machine_district,
                    $m->machine_block,
                    $m->make,
                    $m->serial_no,
                    $m->operator_name,
                    $m->mobile,
                    $m->operator_id,
                    $m->machine_type,
                    $m->code,
                    $m->status,
                    optional($m->created_at)->toDateTimeString(),
                    optional($m->updated_at)->toDateTimeString(),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

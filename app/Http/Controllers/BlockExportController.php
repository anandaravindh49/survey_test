<?php

namespace App\Http\Controllers;

use App\Models\Block;

class BlockExportController extends Controller
{
    public function export()
    {
        $fileName = 'blocks-' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','package_name','state_name','business_area','district_name','block_name','code','status','created_by','updated_by','created_at','updated_at']);

            foreach (Block::cursor() as $b) {
                fputcsv($out, [
                    $b->id,
                    $b->package_name,
                    $b->state_name,
                    $b->business_area,
                    $b->district_name,
                    $b->block_name,
                    $b->code,
                    $b->status,
                    $b->created_by,
                    $b->updated_by,
                    optional($b->created_at)->toDateTimeString(),
                    optional($b->updated_at)->toDateTimeString(),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

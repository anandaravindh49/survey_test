<?php

namespace App\Http\Controllers;

use App\Models\GramPanchayat;

class GramPanchayatExportController extends Controller
{
    public function export()
    {
        $fileName = 'gram_panchayats-' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','state_name','business_area','district_name','block_name','gp_name','gp_code','gp_type','status','created_by','updated_by','created_at','updated_at']);

            foreach (GramPanchayat::cursor() as $g) {
                fputcsv($out, [
                    $g->id,
                    $g->state_name,
                    $g->business_area,
                    $g->district_name,
                    $g->block_name,
                    $g->gp_name,
                    $g->gp_code,
                    $g->gp_type,
                    $g->status,
                    $g->created_by,
                    $g->updated_by,
                    optional($g->created_at)->toDateTimeString(),
                    optional($g->updated_at)->toDateTimeString(),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

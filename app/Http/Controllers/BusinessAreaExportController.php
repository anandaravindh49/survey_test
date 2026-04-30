<?php

namespace App\Http\Controllers;

use App\Models\BusinessArea;

class BusinessAreaExportController extends Controller
{
    public function export()
    {
        $fileName = 'business_areas-' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','package_name','state_name','business_name','code','status','created_by','updated_by','created_at','updated_at']);

            foreach (BusinessArea::cursor() as $b) {
                fputcsv($out, [
                    $b->id,
                    $b->package_name,
                    $b->state_name,
                    $b->business_name,
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

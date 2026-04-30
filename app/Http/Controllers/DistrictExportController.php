<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictExportController extends Controller
{
    public function export()
    {
        $fileName = 'districts-' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','package_name','state_name','district_name','code','status','created_by','updated_by','created_at','updated_at']);

            foreach (District::cursor() as $d) {
                fputcsv($out, [
                    $d->id,
                    $d->package_name,
                    $d->state_name,
                    $d->district_name,
                    $d->code,
                    $d->status,
                    $d->created_by,
                    $d->updated_by,
                    optional($d->created_at)->toDateTimeString(),
                    optional($d->updated_at)->toDateTimeString(),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

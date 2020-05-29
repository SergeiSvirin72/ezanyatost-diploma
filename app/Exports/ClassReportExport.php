<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClassReportExport implements FromView
{
    protected $report, $reportAll, $organisations;

    public function __construct($report, $reportAll, $organisations)
    {
        $this->report = $report;
        $this->reportAll = $reportAll;
        $this->organisations = $organisations;
    }

    public function view(): View
    {
        return view('closed.reports.class.export', [
            'organisations' => $this->organisations,
            'report' => $this->report,
            'reportAll' => $this->reportAll,
        ]);
    }
}

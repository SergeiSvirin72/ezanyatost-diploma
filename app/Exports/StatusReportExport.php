<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StatusReportExport implements FromView
{
    protected $report, $reportAll, $organisations, $statuses;

    public function __construct($report, $reportAll, $organisations, $statuses)
    {
        $this->report = $report;
        $this->reportAll = $reportAll;
        $this->organisations = $organisations;
        $this->statuses = $statuses;
    }

    public function view(): View
    {
        return view('closed.reports.status.export', [
            'organisations' => $this->organisations,
            'report' => $this->report,
            'reportAll' => $this->reportAll,
            'statuses' => $this->statuses,
        ]);
    }
}

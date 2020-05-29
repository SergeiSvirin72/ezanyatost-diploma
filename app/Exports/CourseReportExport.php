<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseReportExport implements FromView
{
    protected $associations, $organisations;

    public function __construct($associations, $organisations)
    {
        $this->associations = $associations;
        $this->organisations = $organisations;
    }

    public function view(): View
    {
        return view('closed.reports.course.export', [
            'organisations' => $this->organisations,
            'associations' => $this->associations,
        ]);
    }
}

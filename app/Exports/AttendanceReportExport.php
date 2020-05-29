<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceReportExport implements FromView
{
    protected $dates, $student, $attendances, $associations;

    public function __construct($dates, $student, $attendances, $associations)
    {
        $this->dates = $dates;
        $this->student = $student;
        $this->attendances = $attendances;
        $this->associations = $associations;
    }

    public function view(): View
    {
        return view('closed.reports.attendance.export', [
            'dates' => $this->dates,
            'student' => $this->student,
            'attendances' => $this->attendances,
            'associations' => $this->associations,
        ]);
    }
}

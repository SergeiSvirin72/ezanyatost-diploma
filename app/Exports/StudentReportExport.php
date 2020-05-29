<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentReportExport implements FromView
{
    protected $student, $associations, $schedules;

    public function __construct($student, $associations, $schedules)
    {
        $this->student = $student;
        $this->associations = $associations;
        $this->schedules = $schedules;
    }

    public function view(): View
    {
        return view('closed.reports.student.export', [
            'student' => $this->student,
            'associations' => $this->associations,
            'schedules' => $this->schedules,
        ]);
    }
}

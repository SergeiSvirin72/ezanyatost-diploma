<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClassReportExport;
use App\Exports\StatusReportExport;
use App\Exports\StudentReportExport;
use App\Exports\CourseReportExport;
use App\Exports\AttendanceReportExport;

class ReportController extends Controller
{
    public function class() {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.reports.class.index', [
            'all' => \Auth::user()['role_id'] == 1 ? true : false,
            'organisations' => $organisations,
        ]);
    }

    public function classFetch() {
        $hasOrganisation = request()->get('hasOrganisation');
        $organisation = request()->input('organisation_id');

        $report = \DB::table('involvements')
            ->join('students',
                'involvements.student_id', '=', 'students.id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) AS count,
                students.class AS class,
                associations.organisation_id AS organisation')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('associations.organisation_id', $hasOrganisation);
            })
            ->groupBy('students.class', 'associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->orderBy('students.class', 'asc')
            ->distinct()
            ->get();

        $reportAll= \DB::table('involvements')
            ->join('students',
                'involvements.student_id', '=', 'students.id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) AS count,
                associations.organisation_id AS organisation')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('associations.organisation_id', $hasOrganisation);
            })
            ->groupBy('associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->distinct()
            ->get();

        $organisations = \App\Organisation::when($organisation, function ($query, $organisation) {
                $query->where('id', $organisation);
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })
            ->get();

        return view('closed.reports.class.index_data', [
            'organisations' => $organisations,
            'report' => $report,
            'reportAll' => $reportAll,
        ]);
    }

    public function classExport()
    {
        $hasOrganisation = request()->get('hasOrganisation');
        $organisation = request()->input('organisation_id');

        $report = \DB::table('involvements')
            ->join('students',
                'involvements.student_id', '=', 'students.id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) AS count,
                students.class AS class,
                associations.organisation_id AS organisation')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('associations.organisation_id', $hasOrganisation);
            })
            ->groupBy('students.class', 'associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->orderBy('students.class', 'asc')
            ->distinct()
            ->get();

        $reportAll= \DB::table('involvements')
            ->join('students',
                'involvements.student_id', '=', 'students.id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) AS count,
                associations.organisation_id AS organisation')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('associations.organisation_id', $hasOrganisation);
            })
            ->groupBy('associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->distinct()
            ->get();

        $organisations = \App\Organisation::when($organisation, function ($query, $organisation) {
            $query->where('id', $organisation);
        })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })
            ->get();

        $export = new ClassReportExport($report, $reportAll, $organisations);

        return Excel::download($export, 'class.xlsx');
    }

    public function status() {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.reports.status.index', [
            'all' => \Auth::user()['role_id'] == 1 ? true : false,
            'organisations' => $organisations,
        ]);
    }

    public function statusFetch() {
        $hasOrganisation = request()->get('hasOrganisation');
        $organisation = request()->input('organisation_id');

        $report = \DB::table('involvements')
            ->join('status_student',
                'involvements.student_id', '=', 'status_student.student_id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT status_student.student_id) AS count, 
                status_student.status_id AS status, associations.organisation_id AS organisation')
            ->distinct()
            ->groupBy('status_student.status_id', 'associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->orderBy('status_student.status_id', 'asc')
            ->get();

        $reportAll = \DB::table('involvements')
            ->join('status_student',
                'involvements.student_id', '=', 'status_student.student_id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) as count, associations.organisation_id AS organisation')
            ->distinct()
            ->groupBy('associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->get();

        $organisations = \App\Organisation::when($organisation, function ($query, $organisation) {
            $query->where('id', $organisation);
        })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })
            ->get();

        $statuses = \App\Status::all();

        return view('closed.reports.status.index_data', [
            'organisations' => $organisations,
            'report' => $report,
            'reportAll' => $reportAll,
            'statuses' => $statuses,
        ]);
    }

    public function statusExport() {
        $hasOrganisation = request()->get('hasOrganisation');
        $organisation = request()->input('organisation_id');

        $report = \DB::table('involvements')
            ->join('status_student',
                'involvements.student_id', '=', 'status_student.student_id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT status_student.student_id) AS count, 
                status_student.status_id AS status, associations.organisation_id AS organisation')
            ->distinct()
            ->groupBy('status_student.status_id', 'associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->orderBy('status_student.status_id', 'asc')
            ->get();

        $reportAll = \DB::table('involvements')
            ->join('status_student',
                'involvements.student_id', '=', 'status_student.student_id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->selectRaw('COUNT(DISTINCT involvements.student_id) as count, associations.organisation_id AS organisation')
            ->distinct()
            ->groupBy('associations.organisation_id')
            ->orderBy('associations.organisation_id', 'asc')
            ->get();

        $organisations = \App\Organisation::when($organisation, function ($query, $organisation) {
            $query->where('id', $organisation);
        })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })
            ->get();

        $statuses = \App\Status::all();

        $export = new StatusReportExport($report, $reportAll, $organisations, $statuses);

        return Excel::download($export, 'status.xlsx');
    }

    public function student() {
        $hasOrganisation = request()->get('hasOrganisation');

        $schools = \App\Organisation::where('is_school', 1)
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })->get();

        return view('closed.reports.student.index', [
            'schools' => $schools,
        ]);
    }

    public function studentFetch() {
        $student_id = request()->input('student_id');

        $student = \DB::table('students')
            ->join('users',
                'students.user_id', '=', 'users.id')
            ->join('organisations',
                'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class',
                'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.id', $student_id)
            ->first();

        $associations = \DB::table('involvements')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->select('associations.id AS id', 'associations.name AS association',
                'organisations.short_name AS organisation', 'organisations.id AS organisation_id')
            ->where('involvements.student_id', $student_id)
            ->orderBy('organisations.id', 'asc')
            ->distinct()
            ->get();

        $schedules = \DB::table('involvements')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->join('teachers',
                'associations.id', '=', 'teachers.association_id')
            ->join('schedules',
                'teachers.id', '=', 'schedules.teacher_id')
            ->join('weekdays',
                'schedules.weekday_id', '=', 'weekdays.id')
            ->select('associations.id AS association',
                'schedules.start', 'schedules.end',
                'weekdays.name AS weekday', 'weekdays.id AS weekday_id')
            ->where('involvements.student_id', $student_id)
            ->orderBy('weekdays.id')
            ->distinct()
            ->get();

        return view('closed.reports.student.index_data', [
            'student' => $student,
            'associations' => $associations,
            'schedules' => $schedules
        ]);
    }

    public function studentExport() {
        $student_id = request()->input('student_id');

        $student = \DB::table('students')
            ->join('users',
                'students.user_id', '=', 'users.id')
            ->join('organisations',
                'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class',
                'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.id', $student_id)
            ->first();

        $associations = \DB::table('involvements')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->select('associations.id AS id', 'associations.name AS association',
                'organisations.short_name AS organisation', 'organisations.id AS organisation_id')
            ->where('involvements.student_id', $student_id)
            ->orderBy('organisations.id', 'asc')
            ->distinct()
            ->get();

        $schedules = \DB::table('involvements')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->join('teachers',
                'associations.id', '=', 'teachers.association_id')
            ->join('schedules',
                'teachers.id', '=', 'schedules.teacher_id')
            ->join('weekdays',
                'schedules.weekday_id', '=', 'weekdays.id')
            ->select('associations.id AS association',
                'schedules.start', 'schedules.end',
                'weekdays.name AS weekday', 'weekdays.id AS weekday_id')
            ->where('involvements.student_id', $student_id)
            ->orderBy('weekdays.id')
            ->distinct()
            ->get();

        $export = new StudentReportExport($student, $associations, $schedules);

        return Excel::download($export, 'student.xlsx');
    }

    public function visit() {
        return view('closed.reports.visit.index');
    }

    public function visitFetch() {
        $start    = (new \DateTime(request()->get('start')));
        $end      = (new \DateTime(request()->get('end')));

        $student = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class', 'students.letter AS letter', 'students.id AS id',
                'organisations.short_name AS organisation')
            ->where('users.id', \Auth::id())
            ->first();


        $weekDays = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('schedules.weekday_id AS weekday')
            ->where('involvements.student_id', $student->id)
            ->distinct()
            ->pluck('weekday')
            ->toArray();

        $dates = generateDates($start, $end, $weekDays);
//        $dates = \DB::table('attendances')
//            ->where('attendances.student_id', $student_id)
//            ->where('attendances.date', '>=', request()->get('start'))
//            ->where('attendances.date', '<=', request()->get('end'))
//            ->orderBy('attendances.date', 'asc')
//            ->pluck('date');

        $associations = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('associations.id', 'associations.name', 'organisations.short_name AS organisation')
            ->where('involvements.student_id', $student->id)
            ->orderBy('associations.name', 'asc')
            ->get();

        $attendances = \DB::table('attendances')
            ->where('attendances.student_id', $student->id)
            ->get();

        return view('closed.reports.attendance.index_data', [
            'dates' => $dates,
            'student' => $student,
            'attendances' => $attendances,
            'associations' => $associations,
        ]);
    }

    public function event() {
        $organisations = \App\Organisation::all();

        return view('closed.reports.event.index', [
            'all' => true,
            'organisations' => $organisations,
        ]);
    }

    public function eventFetch() {
        $organisation = request()->input('organisation_id');

        $events = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->when(request()->get('start'), function ($query, $start) {
                $query->where('events.date', '>=', new \DateTime($start));
            })
            ->when(request()->get('end'), function ($query, $end) {
                $query->where('events.date', '<=', new \DateTime($end));
            })
            ->when($organisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date',
                'organisations.short_name AS organisation')
            ->orderBy('date', 'desc')
            ->get();

        return view('closed.reports.event.index_data', [
            'events' => $events,
        ]);
    }

    public function course() {
        $hasOrganisation = request()->get('hasOrganisation');
        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.reports.course.index', [
            'all' => \Auth::user()['role_id'] == 1 ? true : false,
            'organisations' => $organisations,
        ]);
    }

    public function courseFetch() {
        $organisation = request()->input('organisation_id');
        $course = request()->input('course_id');

        $associations = \DB::table('associations')
            ->join('courses',
                'associations.course_id', '=', 'courses.id')
            ->select('associations.name AS association',
                'courses.name AS course')
            ->when($organisation, function ($query, $organisation) {
                $query->where('associations.organisation_id', $organisation);
            })
            ->when($course, function ($query, $course) {
                $query->where('associations.course_id', $course);
            })
            ->distinct()
            ->orderBy('associations.name', 'asc')
            ->get();

        $organisations = \DB::table('associations')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->select('organisations.short_name AS organisation',
                'associations.name AS association')
            ->when($organisation, function ($query, $organisation) {
                $query->where('associations.organisation_id', $organisation);
            })
            ->when($course, function ($query, $course) {
                $query->where('associations.course_id', $course);
            })
            ->distinct()
            ->get();

        return view('closed.reports.course.index_data', [
            'associations' => $associations,
            'organisations' => $organisations,
        ]);
    }

    public function courseExport() {
        $organisation = request()->input('organisation_id');
        $course = request()->input('course_id');

        $associations = \DB::table('associations')
            ->join('courses',
                'associations.course_id', '=', 'courses.id')
            ->select('associations.name AS association',
                'courses.name AS course')
            ->when($organisation, function ($query, $organisation) {
                $query->where('associations.organisation_id', $organisation);
            })
            ->when($course, function ($query, $course) {
                $query->where('associations.course_id', $course);
            })
            ->distinct()
            ->orderBy('associations.name', 'asc')
            ->get();

        $organisations = \DB::table('associations')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->select('organisations.short_name AS organisation',
                'associations.name AS association')
            ->when($organisation, function ($query, $organisation) {
                $query->where('associations.organisation_id', $organisation);
            })
            ->when($course, function ($query, $course) {
                $query->where('associations.course_id', $course);
            })
            ->distinct()
            ->get();

        $export = new CourseReportExport($associations, $organisations);

        return Excel::download($export, 'course.xlsx');
    }

    public function homeworkStudent() {
        return view('closed.reports.homework.student');
    }

    public function homeworkStudentFetch() {
        $student = \DB::table('students')
            ->join('users',
                'students.user_id', '=', 'users.id')
            ->join('organisations',
                'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class',
                'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.user_id', \Auth::id())
            ->first();

        $homeworks = \DB::table('students')
            ->join('involvements',
                'students.id', '=', 'involvements.student_id')
            ->join('associations',
                'involvements.association_id', '=', 'associations.id')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->join('homeworks',
                'involvements.association_id', '=', 'homeworks.association_id')
            ->select('organisations.short_name AS organisation',
                'associations.name AS association',
                'homeworks.date AS date', 'homeworks.value AS value', 'homeworks.id AS id')
            ->where([
                ['students.user_id', \Auth::id()],
                ['homeworks.date', '>=', (new \DateTime())->modify('-7 day')->format('Y-m-d')],
                ['homeworks.date', '<=', (new \DateTime())->modify('+30 day')->format('Y-m-d')],
            ])
            ->orderBy('homeworks.date', 'desc')
            ->get();

        return view('closed.reports.homework.student_data', [
            'student' => $student,
            'homeworks' => $homeworks,
        ]);
    }

    public function homeworkStudentShow($id) {
        if(!\DB::table('homeworks')->where('id', $id)->exists()) abort(404);

        $homework = \DB::table('homeworks')
            ->join('associations', 'homeworks.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->select('organisations.short_name AS organisation',
                'associations.name as association',
                'homeworks.*')
            ->where('homeworks.id', $id)
            ->first();

        $materials = \App\Material::where('homework_id', $id)->get();

        return view('closed.admin.homeworks.show', [
            'homework' => $homework,
            'materials' => $materials,
        ]);
    }

    public function attendance() {
        $hasOrganisation = request()->get('hasOrganisation');

        $schools = \App\Organisation::where('is_school', 1)
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })->get();

        return view('closed.reports.attendance.index', [
            'schools' => $schools,
        ]);
    }

    public function attendanceFetch() {
        $start    = (new \DateTime(request()->get('start')));
        $end      = (new \DateTime(request()->get('end')));
        $student_id = request('student_id');
//
        $weekDays = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('schedules.weekday_id AS weekday')
            ->where('involvements.student_id', $student_id)
            ->distinct()
            ->pluck('weekday')
            ->toArray();

        $dates = generateDates($start, $end, $weekDays);
//        $dates = \DB::table('attendances')
//            ->where('attendances.student_id', $student_id)
//            ->where('attendances.date', '>=', request()->get('start'))
//            ->where('attendances.date', '<=', request()->get('end'))
//            ->orderBy('attendances.date', 'asc')
//            ->pluck('date');

        $associations = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('associations.id', 'associations.name', 'organisations.short_name AS organisation')
            ->where('involvements.student_id', $student_id)
            ->orderBy('associations.name', 'asc')
            ->get();

        $student = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class', 'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.id', $student_id)
            ->first();

        $attendances = \DB::table('attendances')
            ->where('attendances.student_id', $student_id)
            ->get();

        return view('closed.reports.attendance.index_data', [
            'dates' => $dates,
            'student' => $student,
            'attendances' => $attendances,
            'associations' => $associations,
        ]);
    }

    public function attendanceExport() {
        $start    = (new \DateTime(request()->get('start')));
        $end      = (new \DateTime(request()->get('end')));
        $student_id = request('student_id');

        $weekDays = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('schedules.weekday_id AS weekday')
            ->where('involvements.student_id', $student_id)
            ->distinct()
            ->pluck('weekday')
            ->toArray();

        $dates = generateDates($start, $end, $weekDays);

        $associations = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('involvements', 'associations.id', '=', 'involvements.association_id')
            ->select('associations.id', 'associations.name', 'organisations.short_name AS organisation')
            ->where('involvements.student_id', $student_id)
            ->orderBy('associations.name', 'asc')
            ->get();

        $student = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class', 'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.id', $student_id)
            ->first();

        $attendances = \DB::table('attendances')
            ->where('attendances.student_id', $student_id)
            ->get();

        $export = new AttendanceReportExport($dates, $student, $attendances, $associations);
        return Excel::download($export, 'attendance.xlsx');
    }

    public function involvement() {
        $student = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->select('users.name AS name',
                'students.class AS class',
                'students.letter AS letter',
                'organisations.short_name AS organisation')
            ->where('students.user_id', \Auth::id())
            ->first();

        $associations = \DB::table('involvements')
            ->join('associations', 'involvements.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('students', 'involvements.student_id', '=', 'students.id')
            ->select('associations.id AS id',
                'associations.name AS association',
                'organisations.short_name AS organisation')
            ->where('students.user_id', \Auth::id())
            ->distinct()
            ->orderBy('associations.name', 'asc')
            ->get();

        $schedules = \DB::table('involvements')
            ->join('students', 'involvements.student_id', '=', 'students.id')
            ->join('associations', 'involvements.association_id', '=', 'associations.id')
            ->join('teachers', 'associations.id', '=', 'teachers.association_id')
            ->join('schedules', 'teachers.id', '=', 'schedules.teacher_id')
            ->join('weekdays', 'schedules.weekday_id', '=', 'weekdays.id')
            ->select('associations.id AS association',
                'schedules.start', 'schedules.end',
                'weekdays.name AS weekday', 'weekdays.id AS weekday_id')
            ->where('students.user_id', \Auth::id())
            ->orderBy('weekdays.id')
            ->distinct()
            ->get();

        return view('closed.reports.involvement.index', [
            'student' => $student,
            'associations' => $associations,
            'schedules' => $schedules
        ]);
    }

    public function fetchClasses() {
        $classes = \DB::table('students')
            ->select('students.class AS id', 'students.class AS name')
            ->where('students.organisation_id', request()->input('values.0'))
            ->orderBy('students.class', 'asc')
            ->distinct()
            ->get();

        return view('includes.options', [
            'options' => $classes,
            'name' => 'класс',
        ]);
    }

    public function fetchLetters() {
        $classes = \DB::table('students')
            ->select('students.letter AS id', 'students.letter AS name')
            ->where([
                ['students.class', '=', request()->input('values.1')],
                ['students.organisation_id', '=', request()->input('values.0')],
            ])
            ->orderBy('students.letter', 'asc')
            ->distinct()
            ->get();

        return view('includes.options', [
            'options' => $classes,
            'name' => 'класс',
        ]);
    }

    public function fetchStudents() {
        $students = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.id AS id', 'users.name AS name')
            ->where([
                ['students.letter', '=', request()->input('values.2')],
                ['students.class', '=', request()->input('values.1')],
                ['students.organisation_id', '=', request()->input('values.0')],
            ])
            ->orderBy('users.name', 'asc')
            ->distinct()
            ->get();

        return view('includes.options', [
            'options' => $students,
            'name' => 'обучающегося',
        ]);
    }

    public function fetchCourses() {
        $courses = \DB::table('courses')
            ->select('courses.id AS id', 'courses.name AS name')
            ->get();

        return view('includes.options', [
            'all' => true,
            'options' => $courses,
            'name' => 'направление',
        ]);
    }
}

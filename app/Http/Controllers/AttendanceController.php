<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index() {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.admin.attendances.index', [
            'organisations' => $organisations,
        ]);
    }

    public function fetchData() {
        $start    = (new \DateTime(request()->get('start')));
        $end      = (new \DateTime(request()->get('end')));
        $association_id = request('association_id');

        $weekDays = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->select('schedules.weekday_id AS weekday')
            ->where('teachers.association_id', $association_id)
            ->distinct()
            ->pluck('weekday')
            ->toArray();

        $dates = generateDates($start, $end, $weekDays);

        $students = \DB::table('teachers')
            ->join('involvements', 'teachers.association_id', '=', 'involvements.association_id')
            ->join('students', 'involvements.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.id AS id', 'users.name AS name')
            ->where('teachers.association_id', $association_id)
            ->distinct()
            ->orderBy('users.name', 'asc')
            ->get();

        $attendances = \DB::table('attendances')
            ->join('teachers', 'attendances.association_id', '=', 'teachers.association_id')
            ->select('attendances.*')
            ->where('teachers.association_id', $association_id)
            ->distinct()
            ->get();

        $association = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->select('associations.id', 'associations.name', 'organisations.short_name AS organisation')
            ->where('associations.id', $association_id)
            ->first();

        return view('closed.admin.attendances.index_data', [
            'dates' => $dates,
            'students' => $students,
            'attendances' => $attendances,
            'association' => $association,
        ]);

    }

    public function edit() {
        $value = request()->get('value');
        $association = \DB::table('teachers')
            ->where('teachers.user_id', \Auth::id())
            ->value('association_id');

        if (preg_match('/^[ПОУН]+$/', $value)) {
            $attendance = \App\Attendance::updateOrCreate([
                'student_id' => request()->get('user'),
                'association_id' => request()->get('association'),
                'date' => new \DateTime(request()->get('date')),
            ],[
                'value' => $value,
            ]);
            return 'updateOrCreate';
        }
    }
    public function fetchAssociations() {
        $hasAssociation = request()->get('hasAssociation');

        $associations = \DB::table('associations')
            ->when($hasAssociation, function ($query, $hasAssociation) {
                $query->where('associations.id', $hasAssociation);
            })
            ->where('associations.organisation_id', request()->input('values.0'))
            ->get();

        return view('includes.options', [
            'options' => $associations,
            'name' => 'объединение',
        ]);
    }

}

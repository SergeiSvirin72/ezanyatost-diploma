<?php

namespace App\Http\Controllers;

use App\Imports\StatusesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StatusController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $statuses = \DB::table('status_student')
            ->join('students', 'status_student.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->join('statuses', 'status_student.status_id', '=', 'statuses.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name',
                'students.letter',
                'students.class',
                'status_student.id',
                'statuses.name AS status',
                'organisations.short_name AS organisation')
            ->orderBy('users.name', 'asc')
            ->paginate(20);

        return view('closed.admin.statuses.index', [
            'statuses' => $statuses
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $statuses = \DB::table('status_student')
            ->join('students', 'status_student.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->join('statuses', 'status_student.status_id', '=', 'statuses.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('users.name', 'like', '%'.$search.'%')
                    ->orWhere('students.class', 'like', '%'.$search.'%')
                    ->orWhere('students.letter', 'like', '%'.$search.'%')
                    ->orWhere('statuses.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name',
                'students.letter',
                'students.class',
                'status_student.id',
                'statuses.name AS status',
                'organisations.short_name AS organisation')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(20);



        return view('closed.admin.statuses.index_data', [
            'statuses' => $statuses
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::where('is_school', 1)
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })->get();

        $students = \App\Student::all();
        $statuses = \App\Status::all();

        return view('closed.admin.statuses.create', [
            'organisations' => $organisations,
            'students' => $students,
            'statuses' => $statuses,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'class' => 'required',
            'letter' => 'required',
            'organisation_id' => 'required',
            'student_id' => 'required|unique:status_student,student_id,NULL,NULL,status_id,'.request()->get('status_id'),
            'status_id' => 'required|unique:status_student,status_id,NULL,NULL,student_id,'.request()->get('student_id'),
        ]);


        $status = \App\StatusStudent::create([
            'student_id' => $data['student_id'],
            'status_id' => $data['status_id'],
        ]);

        return back()->with('success', 'Связь успешно добавлена');
    }

    public function destroy($id) {
        $status = \App\StatusStudent::findOrFail($id);
        $status->delete();
        return false;
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
            ->join('users',
                'students.user_id',
                '=',
                'users.id')
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

    public function import()
    {
        $data = request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        Excel::import(new StatusesImport, request()->file('file'));
        return back()->with('success', 'Файл успешно импортирован');
    }
}

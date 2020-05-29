<?php

namespace App\Http\Controllers;

use App\Imports\InvolvementsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvolvementController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $involvements = \DB::table('involvements')
            ->join('associations', 'involvements.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('students', 'involvements.student_id', '=', 'students.id')
            ->join('organisations AS schools', 'students.organisation_id', '=', 'schools.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('involvements.*',
                'associations.name AS association',
                'organisations.short_name AS organisation',
                'students.class AS class',
                'students.letter AS letter',
                'schools.short_name AS school',
                'users.name AS student')
            ->orderBy('users.name', 'asc')
            ->orderBy('associations.name', 'asc')
            ->paginate(20);

        return view('closed.admin.involvements.index', [
            'involvements' => $involvements,
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $involvements = \DB::table('involvements')
            ->join('associations', 'involvements.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->join('students', 'involvements.student_id', '=', 'students.id')
            ->join('organisations AS schools', 'students.organisation_id', '=', 'schools.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('users.name', 'like', '%'.$search.'%')
                    ->orWhere('schools.short_name', 'like', '%'.$search.'%')
                    ->orWhere('students.class', 'like', '%'.$search.'%')
                    ->orWhere('students.letter', 'like', '%'.$search.'%')
                    ->orWhere('associations.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('involvements.*',
                'associations.name AS association',
                'organisations.short_name AS organisation',
                'students.class AS class',
                'students.letter AS letter',
                'schools.short_name AS school',
                'users.name AS student')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(20);



        return view('closed.admin.involvements.index_data', [
            'involvements' => $involvements,
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $schools = \App\Organisation::where('is_school', 1)
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })->get();

        $organisations = \App\Organisation::all();

        return view('closed.admin.involvements.create', [
            'schools' => $schools,
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'school_id' => 'required',
            'class' => 'required',
            'letter' => 'required',
            'student_id' => 'required|unique:involvements,student_id,NULL,NULL,association_id,'.request()->get('association_id'),
            'organisation_id' => 'required',
            'association_id' => 'required|unique:involvements,association_id,NULL,NULL,student_id,'.request()->get('student_id'),
        ]);


        $involvement = \App\Involvement::create([
            'student_id' => $data['student_id'],
            'association_id' => $data['association_id'],
        ]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function destroy($id) {
        $involvement = \App\Involvement::findOrFail($id);
        $involvement->delete();
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

    public function fetchAssociations() {
        $associations = \DB::table('associations')
            ->where('associations.organisation_id', request()->input('values.3'))
            ->orderBy('associations.name', 'asc')
            ->get();

        return view('includes.options', [
            'options' => $associations,
            'name' => 'объединение',
        ]);
    }

    public function import()
    {
        $data = request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        Excel::import(new InvolvementsImport(), request()->file('file'));
        return back()->with('success', 'Файл успешно импортирован');
    }
}

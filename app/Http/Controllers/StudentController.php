<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $students = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->join('genders', 'students.gender_id', '=', 'genders.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name',
                'users.username',
                'students.id as id',
                'genders.name as gender',
                'students.class',
                'students.letter',
                'organisations.short_name AS organisation')
            ->orderBy('users.name', 'asc')
            ->paginate(20);

        return view('closed.admin.students.index', [
            'students' => $students
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $students = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->join('genders', 'students.gender_id', '=', 'genders.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('users.name', 'like', '%'.$search.'%')
                    ->orWhere('users.username', 'like', '%'.$search.'%')
                    ->orWhere('genders.name', 'like', '%'.$search.'%')
                    ->orWhere('students.class', 'like', '%'.$search.'%')
                    ->orWhere('students.letter', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name',
                'users.username',
                'students.id as id',
                'genders.name as gender',
                'students.class',
                'students.letter',
                'organisations.short_name AS organisation')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(20);



        return view('closed.admin.students.index_data', [
            'students' => $students
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::where('is_school', 1)
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        $genders = \App\Gender::all();

        return view('closed.admin.students.create', [
            'organisations' => $organisations,
            'genders' => $genders,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'first_name' => 'required|min:2|max:50|alpha_space',
            'username' => 'required|min:2|max:50|alphanum_dot|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'gender_id' => 'required',
            'class' => 'required|numeric|min:1|max:11',
            'letter' => 'required|alpha|min:1|max:1',
            'organisation_id' => 'required',
        ]);

        $data['role_id'] = 5;
        $data['name'] = $data['first_name'];
        unset($data['first_name']);
        $data['password'] = \Hash::make($data['password']);

        $user = \App\User::create($data);

        $student = \App\Student::create([
            'user_id' => $user->id,
            'gender_id' => $data['gender_id'],
            'class' => $data['class'],
            'letter' => $data['letter'],
            'organisation_id' => $data['organisation_id'],
        ]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function destroy($id) {
        $student = \App\Student::findOrFail($id);
//        $status_student = \App\StatusStudent::where('student_id', $id)->delete();
//        $involvements = \App\Involvement::where('student_id', $id)->delete();
        $student->delete();
        return false;
    }

    public function import()
    {
        $data = request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        Excel::import(new StudentsImport, request()->file('file'));
        return back()->with('success', 'Файл успешно импортирован');
    }
}

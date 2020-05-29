<?php

namespace App\Http\Controllers;

use App\Imports\TeachersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $teachers = \DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name', 'users.username',
                'teachers.id as id',
                'associations.name AS association',
                'organisations.short_name AS organisation')
            ->orderBy('users.name', 'asc')
            ->paginate(10);

        return view('closed.admin.teachers.index', [
            'teachers' => $teachers
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $teachers = \DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('users.name', 'like', '%'.$search.'%')
                    ->orWhere('users.username', 'like', '%'.$search.'%')
                    ->orWhere('associations.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('users.name',
                'users.username',
                'teachers.id as id',
                'associations.name AS association',
                'organisations.short_name AS organisation')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);



        return view('closed.admin.teachers.index_data', [
            'teachers' => $teachers
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.admin.teachers.create', [
            'organisations' => $organisations,
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
            'organisation_id' => 'required',
            'association_id' => 'required',
        ]);

        $data['role_id'] = 3;
        $data['name'] = $data['first_name'];
        unset($data['first_name']);
        $data['password'] = \Hash::make($data['password']);

        $user = \App\User::create($data);

        $teacher = \App\Teacher::create([
            'user_id' => $user->id,
            'association_id' => $data['association_id']
        ]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function destroy($id) {
        $teacher = \App\Teacher::findOrFail($id);
//        $schedules = \App\Schedule::where('teacher_id', $id)->delete();
        $teacher->delete();
        return false;
    }

    public function fetchAssociations() {
        $associations = \DB::table('associations')
            ->where('associations.organisation_id', request()->input('values.0'))
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
        Excel::import(new TeachersImport, request()->file('file'));
        return back()->with('success', 'Файл успешно импортирован');
    }
}

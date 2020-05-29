<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $users = \DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name AS role')
            ->orderBy('users.id', 'asc')
            ->paginate(10);

        return view('closed.admin.users.index', [
            'users' => $users
        ]);
    }

    public function fetchData() {
        $query = request()->get('search');

        $users = \DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.name', 'like', '%'.$query.'%')
            ->orWhere('users.username', 'like', '%'.$query.'%')
            ->orWhere('roles.name', 'like', '%'.$query.'%')
            ->select('users.*',
                'roles.name AS role')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);



        return view('closed.admin.users.index_data', [
            'users' => $users
        ])->render();
    }

    public function create()
    {
        $roles = \App\Role::whereIn('id', [1, 2])->get();
        return view('closed.admin.users.create', [
            'roles' => $roles,
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
            'role_id' => 'required',
        ]);

        $data['name'] = $data['first_name'];
        unset($data['first_name']);

        $data['password'] = \Hash::make($data['password']);

        $user = \App\User::create($data);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function destroy($id) {
        $user = \App\User::findOrFail($id);
        if ($user->role_id === 1) {
            return 'Нельзя удалить администратора';
        }
        $user->delete();
        return false;
    }

    public function import()
    {
        $data = request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

//        Excel::import(new UsersImport, request()->file('file'));
//        return back()->with('success', 'Файл успешно импортирован');

        try {
            Excel::import(new UsersImport, request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors('Строка: '.$failures[0]->row().'. Поле: '.$failures[0]->attribute().'. '.$failures[0]->errors()[0]);
        }
        return back()->with('success', 'Файл успешно импортирован');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.csv');
    }
}

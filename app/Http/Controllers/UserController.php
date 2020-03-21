<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \DB::table('users')
            ->join('roles',
                'users.role_id',
                '=',
                'roles.id')
            ->select('users.*',
                'roles.name AS role')
            ->paginate(20);

        return view('closed.admin.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = \App\Role::all();
        return view('closed.admin.users.create', [
            'roles' => $roles,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'first_name' => 'required|min:2|max:50|alpha_space',
            'username' => 'required|min:2|max:50|alpha_dash|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'role_id' => 'required',
        ]);

        $data['name'] = $data['first_name'];
        unset($data['first_name']);

        $data['password'] = \Hash::make($data['password']);

        $user = \App\User::create($data);

        return back()->with('success', 'Пользователь успешно добавлен');
    }

    public function destroy($id) {
        $user = \App\User::findOrFail($id);
        if ($user->role_id === 1) {
            return back()->withErrors(['Нельзя удалить администратора']);
        }
        $user->delete();
        return back()->with('success', 'Пользователь успешно удален');
    }
}

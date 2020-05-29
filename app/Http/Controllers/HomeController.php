<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (\Auth::user()->role_id) {
            case 2:
                $info = \DB::table('organisations')
                    ->where('director_id', \Auth::id())
                    ->select('organisations.short_name AS organisation')
                    ->first();
                break;
            case 3:
                $info = \DB::table('teachers')
                    ->join('associations', 'teachers.association_id', '=', 'associations.id')
                    ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
                    ->where('teachers.user_id', \Auth::id())
                    ->select('organisations.short_name AS organisation',
                        'associations.name AS association')
                    ->first();
                break;
            case 5:
                $info = \DB::table('students')
                    ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
                    ->join('genders', 'students.gender_id', '=', 'genders.id')
                    ->where('students.user_id', \Auth::id())
                    ->select('organisations.short_name AS organisation',
                        'students.class', 'students.letter',
                        'genders.name AS gender')
                    ->first();

                $statuses = \DB::table('status_student')
                    ->join('statuses', 'status_student.status_id', '=', 'statuses.id')
                    ->join('students', 'status_student.student_id', '=', 'students.id')
                    ->where('students.user_id', \Auth::id())
                    ->pluck('name');

                $info->statuses = $statuses;
                break;
        }

        $role = \DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', \Auth::id())
            ->value('roles.name');

        return view('closed.index', [
            'user' => \Auth::user(),
            'role' => $role,
            'info' => $info ?? null,
        ]);
    }

    public function email()
    {
        $data = request()->validate([
            'email' => 'nullable|email|unique:users',
        ]);

        $user = \Auth::user()->update($data);

        return back()->with('success_email', 'Электронная почта успешно добавлена');
    }

    public function password()
    {
        $data = request()->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        $user = \Auth::user()->update([
            'password' => \Hash::make($data['password']),
        ]);

        return back()->with('success_password', 'Пароль успешно изменен');
    }
}

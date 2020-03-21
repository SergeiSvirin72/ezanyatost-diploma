<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public $weekdays = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье',];

    public function index()
    {
        $schedules = \DB::table('schedules')
            ->join('employments',
                'schedules.employment_id',
                '=',
                'employments.id')
            ->join('users',
                'employments.user_id',
                '=',
                'users.id')
            ->join('activities',
                'employments.activity_id',
                '=',
                'activities.id')
            ->join('associations',
                'activities.association_id',
                '=',
                'associations.id')
            ->join('organisations',
                'activities.organisation_id',
                '=',
                'organisations.id')
            ->select('schedules.*',
                'associations.name as association',
                'organisations.short_name as organisation',
                'users.name as teacher')
            ->orderBy('weekday')
            ->paginate(20);

        return view('closed.admin.schedules.index', [
            'weekdays' => $this->weekdays,
            'schedules' => $schedules,
        ]);
    }

    public function create()
    {
        $users = \App\User::where('role_id', 3)->get();

        $activities = \DB::table('activities')
            ->join('associations',
                'activities.association_id',
                '=',
                'associations.id')
            ->join('organisations',
                'activities.organisation_id',
                '=',
                'organisations.id')
            ->select('activities.*',
                'associations.name AS association',
                'organisations.short_name AS organisation')
            ->get();

        return view('closed.admin.employments.create', [
            'users' => $users,
            'activities' => $activities,
        ]);
    }
}

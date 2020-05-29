<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SchedulesImport;

class ScheduleController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $schedules = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('weekdays', 'schedules.weekday_id', '=', 'weekdays.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('schedules.*',
                'associations.name as association',
                'organisations.short_name as organisation',
                'users.name as teacher',
                'weekdays.name as weekday')
            ->orderBy('weekdays.id', 'asc')
            ->paginate(20);

        return view('closed.admin.schedules.index', [
            'schedules' => $schedules,
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $schedules = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('weekdays', 'schedules.weekday_id', '=', 'weekdays.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('associations.name', 'like', '%'.$search.'%')
                    ->orWhere('weekdays.name', 'like', '%'.$search.'%')
                    ->orWhere('users.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('schedules.*',
                'associations.name as association',
                'organisations.short_name as organisation',
                'users.name as teacher',
                'weekdays.name as weekday')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(20);

        return view('closed.admin.schedules.index_data', [
            'schedules' => $schedules,
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('id', $hasOrganisation);
            })->get();

        $weekdays = \App\Weekday::all();

        return view('closed.admin.schedules.create', [
            'organisations' => $organisations,
            'weekdays' => $weekdays,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'organisation_id' => 'required',
            'association_id' => 'required',
            'teacher_id' => 'required',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'weekday_id' => 'required',
            'classroom' => 'required',
        ]);

//        $employment = \DB::table('employments')
//            ->join('associations',
//                'employments.association_id',
//                '=',
//                'associations.id')
//            ->where([
//                ['associations.id', '=', $data['association_id']],
//                ['associations.organisation_id', '=', $data['organisation_id']],
//                ['employments.teacher_id', '=', $data['teacher_id']],
//            ])
//            ->select('employments.id')
//            ->first();

        $schedule = \App\Schedule::create([
            'teacher_id' => $data['teacher_id'],
            'start' => $data['start'].":00",
            'end' => $data['end'].":00",
            'weekday_id' => $data['weekday_id'],
            'classroom' => $data['classroom'],
        ]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function destroy($id) {
        $schedule = \App\Schedule::findOrFail($id);
        $schedule->delete();
        return back()->with('success', 'Запись успешно удалена');
    }

    public function fetchAssociations() {
        $associations = \DB::table('teachers')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->select('associations.name', 'associations.id')
            ->where('associations.organisation_id', request()->input('values.0'))
            ->distinct()
            ->get();

        return view('includes.options', [
            'options' => $associations,
            'name' => 'объединение',
        ]);
    }

    public function fetchTeachers() {
        $teachers = \DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('users.name', 'teachers.id')
            ->where('teachers.association_id', '=', request()->input('values.1'))
            ->distinct()
            ->get();

        return view('includes.options', [
            'options' => $teachers,
            'name' => 'преподавателя',
        ]);
    }

    public function import()
    {
        $data = request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        Excel::import(new SchedulesImport, request()->file('file'));
        return back()->with('success', 'Файл успешно импортирован');
    }
}

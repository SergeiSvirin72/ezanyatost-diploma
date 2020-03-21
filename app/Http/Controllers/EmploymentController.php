<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    public function index()
    {
        $employments = \DB::table('employments')
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
            ->join('users',
                'employments.user_id',
                '=',
                'users.id')
            ->select('employments.*',
                'associations.name AS association',
                'organisations.short_name AS organisation',
                'users.name AS teacher')
            ->paginate(20);

        return view('closed.admin.employments.index', [
            'employments' => $employments,
        ]);
    }

    public function create()
    {
        $teachers = \App\User::where('role_id', 3)->get();

        $organisations = \DB::table('activities')
            ->join('organisations',
                'activities.organisation_id',
                '=',
                'organisations.id')
            ->select('organisations.id', 'organisations.short_name')
            ->distinct()
            ->get();

        return view('closed.admin.employments.create', [
            'teachers' => $teachers,
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'teacher_id' => 'required',
            'association_id' => 'required',
            'organisation_id' => 'required',
        ]);

        $association = request()->input('association_id');
        $organisation = request()->input('organisation_id');
        $teacher = request()->input('teacher_id');
        $count = \DB::table('employments')
            ->join('activities',
                'employments.activity_id',
                '=',
                'activities.id')
            ->where([
                ['activities.association_id', '=', $association],
                ['activities.organisation_id', '=', $organisation],
                ['employments.user_id', '=', $teacher],
            ])
            ->count();
        if ($count) {
            return back()->withInput()->withErrors(['Такая запись уже существует']);
        }

        //$employment = \App\Employment::create($data);

        return back()->with('success', 'Связь успешно добавлена');
    }

    public function destroy($id) {
        $employment = \App\Employment::findOrFail($id);
        $employment->delete();
        return back()->with('success', 'Связь успешно удалена');
    }

    public function fetchAssociations() {
        $associations = \DB::table('activities')
            ->join('associations',
                'activities.association_id',
                '=',
                'associations.id')
            ->select('associations.name', 'associations.id')
            ->where('activities.organisation_id', request()->input('value'))
            ->get();

        return view('includes.options', [
            'options' => $associations,
            'name' => 'объединение',
        ]);
    }
}

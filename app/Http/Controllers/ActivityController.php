<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
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
            ->orderBy('organisations.id')
            ->paginate(20);

        return view('closed.admin.activities.index', [
            'activities' => $activities,
        ]);
    }

    public function create()
    {
        $organisations = \App\Organisation::all();
        $associations = \App\Association::all();
        return view('closed.admin.activities.create', [
            'associations' => $associations,
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'association_id' => 'required',
            'organisation_id' => 'required',
        ]);

        $association = request()->input('association_id');
        $organisation = request()->input('organisation_id');
        $count = \DB::table('activities')
            ->where([
                ['association_id', '=', $association],
                ['organisation_id', '=', $organisation],
            ])
            ->count();
        if ($count) {
            return back()->withInput()->withErrors(['Такая запись уже существует']);
        }

        $activity = \App\Activity::create($data);

        return back()->with('success', 'Связь успешно добавлена');
    }

    public function destroy($id) {
        $activity = \App\Activity::findOrFail($id);
        $activity->delete();
        return back()->with('success', 'Связь успешно удалена');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $associations = \DB::table('associations')
            ->join('courses',
                'associations.course_id',
                '=',
                'courses.id')
            ->join('organisations',
                'associations.organisation_id',
                '=',
                'organisations.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('associations.id', 'associations.name',
                'courses.name AS course',
                'organisations.short_name AS organisation')
            ->orderBy('organisations.short_name', 'asc')
            ->orderBy('courses.name', 'asc')
            ->paginate(10);

        return view('closed.admin.associations.index', [
            'associations' => $associations,
        ]);
}

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $associations = \DB::table('associations')
            ->join('courses',
                'associations.course_id',
                '=',
                'courses.id')
            ->join('organisations',
                'associations.organisation_id',
                '=',
                'organisations.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('associations.name', 'like', '%'.$search.'%')
                    ->orWhere('courses.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('associations.*',
                'courses.name AS course',
                'organisations.short_name AS organisation')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);



        return view('closed.admin.associations.index_data', [
            'associations' => $associations,
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $courses = \App\Course::all();
        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.admin.associations.create', [
            'courses' => $courses,
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|alpha_space|unique:associations,name,NULL,NULL,organisation_id,'.request()->get('organisation_id'),
            'course_id' => 'required',
            'organisation_id' => 'required'
        ]);
        $association = \App\Association::create($data);

        return back()->with('success', 'Объединение успешно добавлено');
    }

    public function destroy($id) {
        $association = \App\Association::findOrFail($id);
//        $attendances = \App\Attendance::where('association_id', $id)->delete();
//        $homeworks = \App\Homework::where('association_id', $id)->delete();
//        $involvements = \App\Involvement::where('association_id', $id)->delete();
//        $teachers = \App\Teacher::where('association_id', $id)->pluck('id');
//        $schedules = \App\Schedule::whereIn('teacher_id', $teachers)->delete();
//        $teachers = \App\Teacher::where('association_id', $id)->delete();
        $association->delete();
        return false;
    }
}

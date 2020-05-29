<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = \App\Organisation::paginate(10);
        return view('closed.admin.organisations.index', [
            'organisations' => $organisations,
        ]);
    }

    public function fetchData() {
        $organisations = \App\Organisation::orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);
        return view('closed.admin.organisations.index_data', [
            'organisations' => $organisations,
        ])->render();
    }

    public function create()
    {
        $directors = \App\User::where('role_id', 2)->get();
        return view('closed.admin.organisations.create', [
            'directors' => $directors,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'full_name' => 'required',
            'short_name' => 'required',
            'director_id' => 'required|unique:organisations',
            'reception' => 'required',
            'legal_address' => 'required',
            'actual_address' => 'required',
            'phone' => 'required|phone',
            'fax' => 'nullable|phone',
            'email' => 'required|email',
            'website' => 'required',
            'img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data['is_school'] = (boolean)request()->input('is_school');

        $organisation = \App\Organisation::create($data);

        if (request()->has('img')) {
            $path = request()->file('img')->store('public/organisations');
            $path = explode('/', $path);
            unset($path[0]);
            $path = implode('/', $path);
        } else {
            $path = null;
        }
        $organisation->update(['img' => $path]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function show($id) {
        if(!\DB::table('organisations')->where('id', $id)->exists()) abort(404);

        $organisation = \DB::table('organisations')
            ->join('users',
                'organisations.director_id',
                '=',
                'users.id')
            ->select('organisations.*', 'users.name as director')
            ->where('organisations.id', $id)
            ->first();

        return view('closed.admin.organisations.show', [
            'organisation' => $organisation
        ]);
    }

    public function edit($id) {
        $organisation = \App\Organisation::findOrFail($id);
        $directors = \App\User::where('role_id', 2)->get();
        return view('closed.admin.organisations.edit', [
            'organisation' => $organisation,
            'directors' => $directors,
        ]);
    }

    public function update($id) {
        $organisation = \App\Organisation::findOrFail($id);

        $data = request()->validate([
            'full_name' => 'required',
            'short_name' => 'required',
            'director_id' => 'required|unique:organisations,director_id,'.$id,
            'reception' => 'required',
            'legal_address' => 'required',
            'actual_address' => 'required',
            'phone' => 'required|phone',
            'fax' => 'nullable|phone',
            'email' => 'required|email',
            'website' => 'required',
            'img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (request()->has('img')) {
            $path = request()->file('img')->store('public/organisations');
            $path = explode('/', $path);
            unset($path[0]);
            $path = implode('/', $path);
            $data['img'] = $path;
        }
        $data['is_school'] = (boolean)request()->input('is_school');

        $organisation->update($data);

        return back()->with('success', 'Учреждение успешно отредактировано');
    }

    public function destroy($id) {
        $organisation = \App\Organisation::findOrFail($id);
        if ($organisation->img) {
            \Storage::delete('/public/'.$organisation->img);
        }
//        $associations = \App\Association::where('organisation_id', $id)->pluck('id');
//        $attendances = \App\Attendance::whereIn('association_id', $associations)->delete();
//        $homeworks = \App\Homework::whereIn('association_id', $associations)->delete();
//        $involvements = \App\Involvement::whereIn('association_id', $associations)->delete();
//        $teachers = \App\Teacher::whereIn('association_id', $associations)->pluck('id');
//        $schedules = \App\Schedule::whereIn('teacher_id', $teachers)->delete();
//        $teachers = \App\Teacher::whereIn('association_id', $associations)->delete();
//        $associations = \App\Association::where('organisation_id', $id)->delete();
//        $events = \App\Event::where('organisation_id', $id)->delete();
        $organisation->delete();
        return false;
    }

    public function delete_image($id) {
        $organisation = \App\Organisation::findOrFail($id);
        \Storage::delete('/public/'.$organisation->img);
        $organisation->update(['img' => null]);
        return back();
    }
}

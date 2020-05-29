<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OpenedController extends Controller
{
    public function index() {
//        $count = \App\Organisation::all()->count();
//        if ($count >= 3) $count = 3;
//        $organisations = \App\Organisation::all()->random($count);
        $organisations = \App\Organisation::all();
        $events = \App\Event::orderBy('date', 'desc')->limit(3)->get();
        return view('opened.index', [
            'organisations' => $organisations,
            'events' => $events,
        ]);
    }

    public function organisationIndex() {
        $organisations = \App\Organisation::all();
        return view('opened.organisations.index', [
            'organisations' => $organisations
        ]);
    }

    public function organisationShow($id) {
        if(!\DB::table('organisations')->where('id', $id)->exists()) abort(404);

        $organisation = \DB::table('organisations')
            ->join('users',
                'organisations.director_id',
                '=',
                'users.id')
            ->select('organisations.*', 'users.name as director')
            ->where('organisations.id', $id)
            ->first();

        $courses = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('courses', 'associations.course_id', '=', 'courses.id')
            ->select('courses.*')
            ->distinct()
            ->where('associations.organisation_id', '=', $organisation->id)
            ->get();

        return view('opened.organisations.show', [
            'organisation' => $organisation,
            'courses' => $courses,
        ]);
    }

    public function scheduleFetch() {
        $organisation = request('organisation');
        $course = request('course');

        $weekdays = \App\Weekday::all();

        $schedules = \DB::table('schedules')
            ->join('weekdays', 'schedules.weekday_id', '=', 'weekdays.id')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->where([
                ['associations.organisation_id', '=', $organisation],
                ['associations.course_id', '=', $course],
            ])
            ->select('schedules.start', 'schedules.end', 'schedules.classroom', 'schedules.weekday_id AS day',
                'weekdays.name AS weekday', 'users.name AS teacher', 'associations.name AS association')
            ->orderBy('schedules.start')
            ->get();

        return view('opened.organisations.schedule', [
            'weekdays' => $weekdays,
            'schedules' => $schedules,
        ]);
    }

    public function eventIndex() {
        $organisations = \App\Organisation::all();
        return view('opened.events.index', [
            'all' => true,
            'organisations' => $organisations
        ]);
    }

    public function eventFetch() {
        $organisation = request('organisation');

        $events = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->when($organisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date', 'events.content AS content', 'events.img AS img',
                'organisations.short_name AS organisation')
            ->orderBy('date', 'desc')
            ->paginate(9);

        return view('opened.events.index_data', [
            'events' => $events,
        ]);
    }

    public function eventShow($id) {
        if(!\DB::table('events')->where('id', $id)->exists()) abort(404);

        $event = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date', 'events.content AS content', 'events.img AS img',
                'organisations.short_name AS organisation')
            ->where('events.id', $id)
            ->first();

        return view('opened.events.show', [
            'event' => $event
        ]);
    }

    public function contactIndex() {
        return view('opened.contacts', []);
    }

    public function contactSend(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|alpha_space',
            'email' => 'required|email',
            'thee' => 'required|alpha_space',
            'message' => 'required',
        ]);
        Mail::to('admin@admin.com')->send(new FeedbackMail(
            $data['email'], $data['name'], $data['thee'], $data['message']
        ));
        return back()->with('success', 'Сообщение отправлено');
    }
}

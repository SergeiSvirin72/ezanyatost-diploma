<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $events = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->where([
                ['events.date', '>=', (new \DateTime())->modify('-7 day')->format('Y-m-d')],
                ['events.date', '<=', (new \DateTime())->modify('+7 day')->format('Y-m-d')],
            ])
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date',
                'organisations.short_name AS organisation')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('closed.admin.events.index', [
            'events' => $events,
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');

        $events = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('events.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%');
            })
            ->when(request()->get('start'), function ($query, $start) {
                $query->where('events.date', '>=', new \DateTime($start));
            })
            ->when(request()->get('end'), function ($query, $end) {
                $query->where('events.date', '<=', new \DateTime($end));
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date',
                'organisations.short_name AS organisation')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);

        return view('closed.admin.events.index_data', [
            'events' => $events,
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.admin.events.create', [
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'content' => 'required',
            'organisation_id' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = \App\Event::create($data);

        if (request()->has('img')) {
            $path = request()->file('img')->store('public/events');
            $path = explode('/', $path);
            unset($path[0]);
            $path = implode('/', $path);
        } else {
            $path = null;
        }
        $event->update(['img' => $path]);

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function show($id) {
        if(!\DB::table('events')->where('id', $id)->exists()) abort(404);

        $event = \DB::table('events')
            ->join('organisations', 'events.organisation_id', '=', 'organisations.id')
            ->select('events.id AS id', 'events.name AS name', 'events.date AS date', 'events.content AS content', 'events.img AS img',
                'organisations.short_name AS organisation')
            ->where('events.id', $id)
            ->first();

        return view('closed.admin.events.show', [
            'event' => $event
        ]);
    }

    public function destroy($id) {
        $event = \App\Event::findOrFail($id);
        if ($event->img) {
            \Storage::delete('/public/'.$event->img);
        }
        $event->delete();
        return false;
    }
}

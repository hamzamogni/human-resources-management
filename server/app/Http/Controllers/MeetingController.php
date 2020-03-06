<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Cell;
use App\Mail\MeetingSchedueled;
use Illuminate\Http\Request;
use App\Http\Resources\MeetingResource;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response(MeetingResource::collection(Meeting::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cell = Cell::find($request->cell_id);
        $new_meeting = new Meeting($request->except("cell_id"));
        $new_meeting->cell()->associate($cell);
        $new_meeting->save();

        foreach ($cell->users as $user) {
            Mail::to($user)->send(new MeetingSchedueled($new_meeting, $user, $cell));
        }

        
        return Response(new MeetingResource($new_meeting));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meeting = Meeting::FindOrFail($id);
        $meeting->update($request->except("cell"));
        return Response($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->delete();
        return Response("deleted successfully", 200);
    }
}

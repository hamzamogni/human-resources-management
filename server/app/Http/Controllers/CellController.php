<?php

namespace App\Http\Controllers;

use App\Cell;
use App\User;
use App\Http\Resources\CellResource;
use http\Env\Response;
use Illuminate\Http\Request;

class CellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response(
            CellResource::collection(
                Cell::doesntHave("parent")
                    ->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cell = new Cell($request->except(["isSubcell", "parent_id"]));

        if($request->isSubcell)
        {
            $parent = Cell::findOrFail($request->parent_id);
            $cell->parent()->associate($parent);
            $cell->save();
            return Response("done");
        }
        else 
        {
            $cell->save();
            return Response("done");
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Cell $cell
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CellResource(Cell::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cell $cell
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cell $cell)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cell $cell
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cell = Cell::findOrFail($id);
        $cell->removeChief();
        $cell->delete();
        return Response("done");
    }

    public function update_chief(Request $request, $id)
    {
        $cell = Cell::findOrFail($id);
        $cell->assignChief($request->chief_id);
        return Response(new CellResource(Cell::findOrFail($id)));
    }

    public function delete_chief($id)
    {
        $cell = Cell::findOrFail($id);
        $cell->removeChief();
        return Response(new CellResource(Cell::findOrFail($id)));
    }

    public function add_member(Request $request, $cellID)
    {
        $cell = Cell::findOrFail($cellID);
        $member = User::findOrFail($request->member_id);
        $member->makeNotChief();
        $member->cell()->associate($cell);
        $member->save();
        return Response(new CellResource($cell));
    }

    public function delete_member(Request $request, $cellID)
    {
        $cell = Cell::findOrFail($cellID);
        $member = User::findOrFail($request->member_id);
        $member->makeNotchief();
        $member->cell()->dissociate($cell);
        $member->save();
        return Response(new CellResource($cell));
    }
}

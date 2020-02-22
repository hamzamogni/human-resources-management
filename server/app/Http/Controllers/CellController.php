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
        return $request;
        $cell = new Cell($request->except(["isSubcell", "parent_id"]));
        // if($request->isSubcell)
        
        
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
        $cell->delete();
        return Response("done");
    }

    public function update_chief(Request $request, $id)
    {
        $cell = Cell::findOrFail($id);
        $user = User::findOrFail($request->chief_id);
        $cell->chief()->associate($user);
        $cell->save();
        return Response(new CellResource($cell));
    }

    public function delete_chief($id)
    {
        $cell = Cell::findOrFail($id);
        $cell->chief()->dissociate();
        $cell->save();
        return Response(new CellResource($cell));
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CellResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'users' => $this->users,
            'hasChief' => $this->hasChief,
            'chief' => $this->chief,
            'children' => CellResource::collection($this->children),
            'count_users' => $this->users->count(),
            "isSubcell" => $this->isSubcell
        ];

        // if($this->chief == null)
        //     $data["chief"] = [];

        return $data;

    }

    public function with($request)
    {
        return [

        ];
    }
}

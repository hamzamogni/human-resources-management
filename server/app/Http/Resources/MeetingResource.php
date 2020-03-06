<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CellResouce;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "meeting_date" => $this->meeting_date,
            "meeting_time" => $this->meeting_time,
            "cell" => new CellResource($this->cell),
        ];
    }
}

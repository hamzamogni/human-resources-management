<?php

namespace App\Http\Resources;

use App\Http\Resources\CellResource;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $      request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'project' => $this->project,
            'cell' => $this->cell,
            'fullname' => $this->fullname,
        ];
    }

    public function with($request)
    {
        return [

        ];
    }
}

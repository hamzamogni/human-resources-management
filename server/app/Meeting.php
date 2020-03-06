<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    protected $fillable = ["meeting_date", "meeting_time"];

    public function cell()
    {
        return $this->belongsTo("App\Cell");
    }
}

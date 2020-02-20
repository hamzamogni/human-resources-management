<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    protected $guarded = ["id"];
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function chief()
    {
        return $this->belongsTo("App\User", "chief_id");
    }

    public function parent() {
        return $this->belongsTo("App\Cell", "parent_id");
    }

    public function children() {
        return $this->hasMany("App\Cell", "parent_id");
    }

    public function getHasChiefAttribute()
    {
        return $this->chief != null;
    }

    public function getIsSubcellAttribute()
    {
        return $this->parent != null;
    }
}

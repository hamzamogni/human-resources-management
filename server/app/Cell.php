<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Cell extends Model
{
    protected $guarded = ["id"];

    protected $appends = ['chief'];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function meetings()
    {
        return $this->hasMany("App\Meeting");
    }

    public function getChiefAttribute()
    {
        return $this->users()->where("chief", 1);
    }

    public function parent() {
        return $this->belongsTo("App\Cell", "parent_id");
    }

    public function children() {
        return $this->hasMany("App\Cell", "parent_id");
    }

    public function getHasChiefAttribute()
    {
        return $this->chief->count() == 1;
    }

    public function getIsSubcellAttribute()
    {
        return $this->parent != null;
    }

    public function assignChief($id)
    {
        $user = User::findOrFail($id);
        if ($this->has_chief && $this->chief->get()->first()->id === $id)
            return "already chief";
        else 
        {
            $this->removeChief();
            $user->makeChief();
            return "done";
        }
            
    }

    public function removeChief()
    {
        if ($this->has_chief)
            $this->chief->get()->first()->makeNotChief();
    }
}

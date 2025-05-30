<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    protected $guarded = ['id'];

    public function openings()
    {
        return $this->hasMany(Opening::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function absents()
    {
        return $this->hasMany(Absent::class);
    }

}

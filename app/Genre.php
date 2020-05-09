<?php

namespace App;

use App\Movie;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function movies()
    {
        return $this->hasMany('App\Movie');
    }
}

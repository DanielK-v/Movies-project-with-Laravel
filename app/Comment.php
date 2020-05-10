<?php

namespace App;
use App\Movie as Movie;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public $canBeDeleted = false;

    public function movie()
    {
        return $this->belongsTo('App\Movie');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

<?php

namespace App;
use App\Genre;
use App\Comment;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

   protected $fillabe = ['title', 'genre', 'year', 'cover_img', 'description'];

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}

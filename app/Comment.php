<?php

namespace App;
use App\Movie as Movie;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function movie()
    {
        return $this->belongsTo('App\Movie');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // public static function getComments()
    // {

    //     $number_of_comments = count($comments);
    //     $comments = Comment::where('movie_id', Movie->id)->get()->toArray();

    //     return json_encode($comments);
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Comment as Comment;
use App\Movie as movie;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = request('movie_id');
        $comments_for_movie = Comment::with('user')
            ->where('movie_id', '=', $id)
            ->orderBy('created_at', 'desc')->get();

        return $comments_for_movie->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $this->validateComment($request);
            $new_comment = new Comment();

            $user_id = Auth::user()->id;

            $new_comment->comment = $request->comment;
            $new_comment->user_id = $user_id;
            $new_comment->movie_id = $request->movie_id;

            $new_comment->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = request('movie_id');

        $comments_for_movie = Comment::with('user')->where('movie_id', '=', $id)->get();
        return response()->json(["data" => $id]);
        return response()->json(["data" => $comments_for_movie]);

        $number_of_comments = count($comments_for_movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {

        $this->authorize('delete', $comment);
        $comment->delete();
    }

    public function validateComment($request)
    {

        if (request()->has('comment'){
            request()->validate([
                'comment' => 'required|max:5000'
            ])});

        return $request;
    }
}

<?php

namespace App\Http\Controllers;

use App\Movie as Movie;
use App\Genre as Genre;
use App\Comment as Comment;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();

        return view('/movies.index')->with('movies',$movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Movie::class);
        $genres = Genre::All()->toArray();

        return view('/movies.create')->with('genres', $genres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', Movie::class);
        
        $this->validateRequest($request);

        $movie = new Movie();
        
        $movie->title = $request->title;
        $movie->year = $request->year;
        $movie->genre_id = (int)$request->genre;
        $movie->description = $request->description;
        $movie->cover_img = $this->storeImage();
        $movie->save();
        
        return  redirect('/movies',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $comments = Comment::where('movie_id', $movie->id)->orderBy('created_at', 'desc')->get();
    
        $number_of_comments = count($comments);
        
        return view('/movies.show',[
         'movie' =>$movie,
         'comments' =>$comments, 
         'number_of_comments' => $number_of_comments
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movies
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $this->authorize('edit', $movie);
        $genres = Genre::All()->toArray();
    
        return view('/movies.edit')->with(['genres' => $genres, 'movie'=>$movie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {

        
        $this->validateRequest($request);
    
        $movie->title = $request->title;
        $movie->year = $request->year;
        $movie->genre_id = (int)$request->genre;
        $movie->cover_img  =  $this->storeImage() ? $this->storeImage() : $movie->cover_img;

        $movie->update();
        return  redirect('/movies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $this->authorize('delete', $movie);
        $movie->delete();
        // return response()
        return redirect()->back();
    }

    public function validateRequest($request)
    {

        $request = request()->validate([
            'title' => 'required|min:3',
            'year' => 'required|int',
            'description' =>'required|min:3|max:2000'
        ]);

        if(request()->hasfile('cover_img'){
            request()->validate([
                'cover_img' => 'file|image|max:5000'
            ])
        });

        return $request;
    }

    public function storeImage()
    {

      if(request()->has('cover_img')){
        return request()->cover_img->store('uploads', 'public');
      }

      return false;

    }
    
}

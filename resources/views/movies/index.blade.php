@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @foreach ($movies as $movie)

            <div class="col-xs-12 col-sm-2 col-md-3 mt-2">
            <a href="/movies/{{$movie->id}}">
                <img src="{{URL::asset('storage/' . $movie->cover_img)}}" alt="cover Pic" height="300" width="200">
            </a>
                
                 <h2>{{$movie->title}}</h2>
                <span><strong>Year:</strong>{{$movie->year}}</span>
                @can('delete', App\Movie::class)
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{$movie->id}}">
                    Delete
                 </button>
                 @endcan
                 @can('update', App\Movie::class)
                    <a href="/movies/{{$movie->id}}/edit" class="btn btn-outline-warning">Edit</a>
                @endcan
            </div>
        
            @can('delete', App\Movie::class)
            <!-- The Delete Modal -->
            <div class="modal" id="{{$movie->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure you want to delete {{$movie->title}} ?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <form method="POST" action="/movies/{{$movie->id}}" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </div>
                    
                </div>
            </div>
            @endcan
        </div>
    @endforeach 
</div>  
    
@endsection

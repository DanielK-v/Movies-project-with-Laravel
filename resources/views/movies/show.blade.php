@extends('layouts.app')
@section('content')

<div class="container">
  <div class="card">
    <div class="card-body">
      <h1 class="card-title">{{$movie->title}}</h1>
      <div class="row">
        
        <img class="col-3" src="{{ URL::asset('storage/uploads/' . $movie->cover_img) }}" alt="cover Pic" height="300" width="200">
        <iframe class="col-9" width="420" height="280" src="https://www.youtube.com/embed/r_0JjYUe5jo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
     
      <hr>
    <p class="card-text">{{$movie->description}}</p>
      <a href="#" class="card-link">Card link</a>
      <a href="#" class="card-link">Another link</a>
    </div>
  </div>

  <div class="col-md-12">
      <h2>Comments</h2>
      </div>

      @auth    
      <div class="col-md-12 mb-5" id="addcomment">
          <form>
              <input type="hidden" id="movie_id" name="movie_id" value={{$movie->id}}>
              <textarea id="textarea" class="form-control" name="comment" placeholder="Comment content..." ></textarea><br/>
              <button class="btn-submit btn-primary">Add comment</button>
          </form>
      </div>
      @endauth

      @forelse ($comments as $comment)
    
        <div id="comments" class="row-md-12" ></div>
      
      @empty
      <div id="comments"class="col-md-12">
        <div class="head mt-5">
        <p class="">There are no comments for that movie yet.. :(</p>
      </div>    
        
    </div>
      @endforelse
     
    </div>
  </div>
  
  <script>
    const comments = document.getElementById('comments');  
    
      function getComments(){
        $.ajax({
    
              type:'GET',
    
              url:'/comment',
    
              dataType: 'json',
    
              data: {
                "movie_id" : {{$movie->id}}
              },
    
              success:function(data){
    
                data.forEach(comment => {
                  comments.innerHTML +=
                    `<div class="head mt-5">
                        <small><strong class="user">${comment['user']['name']}</strong> ${comment['created_at']}</small>
                    </div>
                   
                     <div>
                        <p>${comment['comment']} </p>
                    
                  <div class='pull-right'>
                    <form method='POST' action="/comment/${comment['id']}" >
                      @csrf
                      @method('DELETE')
                        <button type='submit' style='color:red'>X</button>
                    </form>
                  </div>
                  </div>
                  <hr/>
                  `
                });
            }
        });
      }
    
      $(".btn-submit").click(function(e){
          const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
        e.preventDefault();
          const comment = $("#textarea").val();
    
          const movie_id = $("#movie_id").val();
          $.ajax({
    
            type:'POST',
    
            url:'/comments',
    
            data:{comment, movie_id, _token: CSRF_TOKEN},
    
          });
          comments.innerHTML = '';
          getComments();
      });
     
    
    $( document ).ready(function() {
      getComments();
    });
    </script>
@endsection
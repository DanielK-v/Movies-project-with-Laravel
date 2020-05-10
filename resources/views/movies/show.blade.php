@extends('layouts.app')
@section('content')

<div class="container">
  <div class="card">
    <div class="card-body">
      <h1 class="card-title">{{$movie->title}}</h1>
      <hr>
      <div class="row">
        
        <img class="col-3" src="{{ URL::asset('storage/' . $movie->cover_img) }}" alt="cover Pic" height="300" width="200">
        <iframe 
          class="col-9" 
          width="420" 
          height="280" 
          src="{{$movie->trailer_url}}" 
          frameborder="0" 
          allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
          allowfullscreen>
      </iframe>
      </div>
     
      <hr>
      <p class="card-text">{{$movie->description}}</p>
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
    
        <div id="comments" class="row-md-12" ></div>
        
     </div>
      
    </div>
  </div>
  
  <script>
    const comments = document.getElementById('comments');  

      function getComments(){
        $.ajax({
    
              type:'GET',
    
              url:'/comments',
    
              dataType: 'json',
    
              data: {
                "movie_id" : {{$movie->id}}
              },
    
              success:function(data){

                if(data.length < 1) {
                  comments.innerHTML += 
                  ` <div id="comments"class="col-md-12">
                      <div class="head mt-5">
                      <p class="">There are no comments for that movie yet.. :(</p>
                    </div> 
                  <hr/>
                  `

                }
                data.forEach(comment => {
                  comments.innerHTML +=
                    `<div class="head mt-5">
                        <small><strong class="user">${comment['user']['name']}</strong> ${comment['created_at']}</small>
                    </div>
                   
                    <div>
                        <p>${comment['comment']} </p>
                    
                        <div class='pull-right'>
                    
                    <button id='del-btn' type='submit' style='color:red' onclick='deleteComment(${comment['id']})'>X</button>
            
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
     
    
     function deleteComment (id) {
         const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
          $.ajax({
    
            type:'DELETE',
    
            url:'/comments/' + id,
    
            data:{ _token: CSRF_TOKEN},
    
          });
          comments.innerHTML = '';
          getComments();
      };


    $( document ).ready(function() {
      getComments();
    });
    
    </script>
@endsection
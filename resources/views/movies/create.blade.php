@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Movie') }}</div>

                <div class="card-body">
                    <form method="POST" action="/movie" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="genre" class="col-md-4 col-form-label text-md-right">{{ __('genre') }}</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1" name="genre">
                                     @foreach ($genres as $genre)
                                        <option value="{{$genre['id']}}">{{$genre['genre']}}</option>
                                     @endforeach
                                    </select>
                                  </div>

                                @error('genre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="input-group date">
                                <label for="year" class="col-md-4 col-form-label text-md-right">{{ __('year') }}</label>
                                <div class="col-md-6">
                                <input class="date-own form-control" type="text" name="year">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cover_img"  class="col-md-4 col-form-label text-md-right">Cover</label>

                            <div class="col-md-6">
                           
                                <input type="file" class="form-control-file" id="cover_img" name="cover_img">
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Movie description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" cols="20"></textarea>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register movie') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date-own').datepicker({
       minViewMode: 2,
       format: 'yyyy'
     });
</script>
@endsection
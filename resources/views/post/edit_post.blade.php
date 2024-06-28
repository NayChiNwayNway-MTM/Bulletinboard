@extends('layouts.nav')
  @section('content')
<section class="background">
  <div class="container col-md-6 margin">
  <div class="card m-auto mt-5" style="width: 60rem;">
    <div class="card-body">
    <form action="{{route('post_edit_confirm',$post->id)}}" method="post">
      @csrf 
      <div class="row">
      <div class= "mb-5"><h4 class="text-primary text-center mt-2">Edit Post</h4></div>
      </div>
      <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-2">Title <span class="text-danger">&#42;</span></label>
        <div class="col-8"><input type="text" class="form-control" name="title" value="{{$post->title}}"></div>
      </div>
      <div class="row mt-2">
        <div class="col-4"></div>
        <div class="col-6">
        <span class="text-danger ">
          @error('title')
            {{$message}}
          @enderror
        </span>
        </div>
      </div>     
      <div class="row d-flex justify-content-around align-item-center mt-5 ">
        <label for="" class="form-label col-2">Description <span class="text-danger">&#42;</span></label>
        <div class="col-8"><textarea name="description" id="" cols="40" rows="3" class="form-control">{{$post->description}}</textarea></div>
      </div>
      <div class="row mt-2">
        <div class="col-4"></div>
        <div class="col-6">
          <span class="text-danger ">
            @error('description')
              {{$message}}
            @enderror
          </span>
        </div>
      </div>
      <div class="row mt-3">
        <div class="form-check form-switch col-4">
          <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>            
        </div>
        <div class="form-check form-switch col-8">
          <input class="form-check-input" type="checkbox" name='status' role="switch" id="flexSwitchCheckDefault" {{ $post->status == 1 ? 'checked' : 'off' }} >    
        </div>
      </div>
      <div class="row justify-content-around align-item-center m-5 ">
        <div class="col-sm-6 d-flex justify-content-around align-item-center">
          <button class="btn btn-info col-sm-4">Edit</button>
          <form action="" method="post">
            @csrf 
            <button class="btn btn-primary col-4" type="reset">Clear</button>
          </form>
        </div>        
      </div>
    </form>
  </div>
  </div>
  </div>
</section>
 
  @endsection

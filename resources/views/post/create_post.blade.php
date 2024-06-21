@extends('layouts.nav')
  @section('content')

  <div class="container col-md-6 mt-5">
    <form action="{{route('post.create')}}" method="get" class="border border-primary rounded ">
      <div class="row">
      <div class= "mb-5"><h4 class="text-primary text-center mt-2">Create Post</h4></div>
      </div>
      @csrf 
      @if(Session::has('postcreated'))
                <div class="alert alert-success" role="alert" id='alert'>
                    {{Session::get('postcreated')}}
                </div>
      @endif
      <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-sm-2">Title <span class="text-danger">&#42;</span></label>
        <div class="col-sm-8"><input type="text" class="form-control" name="title"></div>
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
        <label for="" class="form-label col-sm-2">Description <span class="text-danger">&#42;</span></label>
        <div class="col-sm-8"><textarea name="description" id="" cols="40" rows="3" class="form-control"></textarea></div>
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
      <div class="row d-flex justify-content-around align-item-center m-5 ">
        <div class="col-sm-6">
          <button class="btn btn-info col-sm-4">Create</button>
          <form action="" method="post">
            @csrf 
            <button class="btn btn-primary col-4" type="reset">Clear</button>
          </form>
        </div>        
      </div>
    </form>
  </div>

  @endsection
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


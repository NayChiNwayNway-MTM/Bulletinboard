@extends('layouts.nav')
  @section('content')
<section class="background">

  <div class="container margin">
  <div class="card m-auto " style="width: 60rem;">
    <div class="card-body">
    
    <form action="{{route('post.create')}}" method="get" class="">
      @csrf 
    
      <div class="row">
      <div class= "mb-5"><h4 class="text-primary text-center mt-2">Create Post</h4></div>
      </div>
    
     
      <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-sm-2">Title <span class="text-danger">&#42;</span></label>
        <div class="col-sm-8"><input type="text" class="form-control" name="title"
         value="{{old('title')}}" autofocus></div>
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
        <div class="col-sm-8"><textarea name="description" id="" cols="40" rows="3" class="form-control">
        {{old('description')}}</textarea></div>
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
      <div class="row  justify-content-center align-items-center m-5 ">
        <div class="col-sm-6 d-flex justify-content-center align-items-center">
          <button class="btn btn-info col-sm-4 mx-2">Create</button>
          <form action="" method="post">
            @csrf 
            <button class="btn btn-primary col-4 mx-2" type="reset">Clear</button>
          </form>
        </div>        
      </div>
    </form>
  </div>
  </div>
  </div>
</section>
  @endsection
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


@extends('layouts.nav')
  @section('content')

<div class="row bg-primary mb-5"><p>Confirm Post</p></div>
  <div class="container col-md-6 mt-5">
    <form action="{{route('post.store')}}" method="post">
      @csrf 
      <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-sm-2">Title <span class="text-danger">&#42;</span></label>
        <div class="col-sm-8"><input type="text" class="form-control" name="title" value="{{$title}}"></div>
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
        <div class="col-sm-8"><textarea name="description" id="" cols="40" rows="3" class="form-control">{{$des}}</textarea></div>
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
          <button class="btn btn-info col-sm-4">Comfirm</button>
          <form action="{{route('post.create')}}" method="get">
            @csrf 
            <button class="btn btn-primary col-4" type="reset">Cancle</button>
          </form>
          
        </div>        
      </div>
    </form>
  </div>
  @endsection

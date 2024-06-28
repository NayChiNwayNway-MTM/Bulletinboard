@extends('layouts.nav')
  @section('content')
  <section class="background">
    @if(session('error'))
  <div class="alert alert-danger" id="alert">
    {{session('error')}}
  </div>
  @endif
 
      <div class="container col-md-6 margin">
        <div class="card m-auto " style="width: 60rem;">
          <div class="card-body">
            <form action="{{route('post.store')}}" method="post" class="">
              @csrf 
              <div class="row mb-5"><h3 class="text-primary text-center">Confirm Post</h3></div>
              <div class="row d-flex justify-content-around align-item-center">
                <label for="" class="form-label col-sm-2">Title <span class="text-danger">&#42;</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$title}}">
                </div>
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
                <div class="col-sm-6 d-flex justify-content-around align-item-center">
                  <button class="btn btn-info col-sm-4 mx-1">Comfirm</button>
                  <form action="{{route('post.create')}}" method="get">
                    @csrf 
                    <button class="btn btn-primary col-4 mx-1" type="reset">Cancle</button>
                  </form>
                  
                </div>        
              </div>
            </form>
          </div>
        </div>
      </div>
  </section>

  @endsection

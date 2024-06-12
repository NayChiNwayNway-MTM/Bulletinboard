@extends('layouts.master')
@section('content')
<div class="row"><h2 class="bg-success p-2">Sign up</h2></div>
<div class="container">
  <form action="{{route('signup')}}" method="post" class="mt-5" enctype="multipart/form-data">
    @csrf     
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="name" class="form-control">
          <span class="text-danger ">
            @error('name')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
    
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">E-Mail Address<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="email" name="email" class="form-control">
          <span class="text-danger ">
            @error('email')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
    
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="password" class="form-control">
          <span class="text-danger ">
            @error('password')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
   
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Confirm Password<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="confirm-password" class="form-control">
        <span class="text-danger ">
          @error('confirm-password')
            {{$message}}
          @enderror
        </span>
      </div>
    </div>
    <div class="row d-flex justify-content-around align-item-center mt-3 mb-3">
        <div class="col-sm-6">
          <button class="btn btn-info col-4">Create</button>
          <form action="" method="post">
            @csrf 
            <button class="btn btn-primary col-4" type="reset">Clear</button>
          </form>
        </div>        
      </div>
  </form>
  </div>
</form>
</div>
@endsection
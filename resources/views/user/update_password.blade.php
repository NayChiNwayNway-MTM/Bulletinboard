@extends('layouts.nav')
@section('content')

<div class="container">
<header><h2 class="bg-success mt-5">Reset Password</h2></header>
  <form action="{{route('updatepassword')}}" method="post" class="mt-5" enctype="multipart/form-data">
    @csrf 
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
      <div class="col-2 "><label for="" class="form-label float-end">Password Conformation<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="password_confirm" class="form-control">
          <span class="text-danger ">
            @error('password_confirm')
              {{$message}}
            @enderror
          </span>
          <div class="row mt-4">
                <div class="col-3">
                  <button class="btn btn-success">Confirm Password</button>
                </div>
              </div>
      </div>
    </div>   
</form>
</div>  
@endsection
@extends('layouts.master')
@section('content')

<div class="container">

  <form action="{{route('resetpassword.post')}}" method="post" class="border border-primary rounded mt-5">
    @csrf 
    <div class="row">
      <header><h2 class="text-center text-primary">Reset Password</h2></header>
    </div>
    <input type="hidden" name="token" value="{{ $user_token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="password" name="password" class="form-control">
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
        <input type="password" name="password_confirm" class="form-control">
          <span class="text-danger ">
            @error('password_confirm')
              {{$message}}
            @enderror
          </span>
          <div class="row mt-4 justify-content-center align-items-center">
                <div class="col-3 d-flex justify-content-center align-items-center">
                  <button class="btn btn-info mb-5">Confirm Password</button>
                </div>
              </div>
      </div>
    </div>   
</form>
</div>  
@endsection
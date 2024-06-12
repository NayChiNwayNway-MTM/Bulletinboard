@extends('layouts.master')
@section('content')
    <div class="container col-md-6  mt-5 border border-primary rounded">
      <div class="row bg bg-primary mb-5 rounded">
        <p class="">Login</p>
      </div>
      <form action="" method="get">
        @csrf
        <div class="row mb-3">
          <label for="" class="col-sm-2 col-form-label">Email Address:<span class="text-danger">&#42;</span></label>
          <div class="col-sm-8"><input type="text" class="form-control" name="email"></div>
        </div>
        <div class="row mb-3">
          <label for="" class="col-sm-2 col-form-label">Password: <span class="text-danger">&#42;</span></label>
          <div class="col-sm-8"><input type="text" class="form-control" name="password"></div>
        </div>
        <div class="row">
          <div class="col-md-10">
            <div class="d-flex justify-content-around align-items-center mb-4">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" value="">
                <label for="" class="form-check-label">Remember me</label>
              </div>
              <a href="{{route('forgetpassword')}}">Forgot passwords?</a>
            </div>
          </div>       
        </div>
        <div class="row">
          <div class="col-md-2"></div>
            <div class="d-flex align-item-center justify-content-around"><button class="btn btn-primary col-md-6">Login</button></div>
        </div>
        <div class="row text-center mt-5 mb-5">
          <a href="{{route('signup')}}">Create account?
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
          </a>
        </div>
      </form>     
    </div>
@endsection
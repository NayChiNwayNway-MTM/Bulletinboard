@extends('layouts.master')
@section('content')
<section class="background">
<div class="container">
  <div class="card m-auto mt-5" style="width: 60rem;">
        <div class="card-body justify-content-center align-items-center">
            <form action="{{route('resetpassword.post')}}" method="post" class="">
              @csrf 
              <div class="row">
                <header><h2 class="text-center text-primary">Reset Password</h2></header>
              </div>
              <input type="hidden" name="token" value="{{ $user_token }}">
              <input type="hidden" name="email" value="{{ $email }}">
              <div class="row d-flex mt-3">
                <div class="col-3 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
                <div class="col-7 password">
                  <input type="password" name="password" id="password" class="form-control">
                  <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Shwo Password"></i>
                    <span class="text-danger ">
                      @error('password')
                        {{$message}}
                      @enderror
                    </span>
                </div>
              </div>   
              <div class="row d-flex mt-3">
                <div class="col-3 "><label for="" class="form-label float-end">Password Conformation<span class="text-danger">&#42;</span></label></div>
                <div class="col-7 password">
                  <input type="password" name="password_confirm" id="con_password" class="form-control">
                  <i class="far fa-eye eyeicon" id="con_togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                    <span class="text-danger ">
                      @error('password_confirm')
                        {{$message}}
                      @enderror
                    </span>
                    <div class="row mt-4 justify-content-center align-items-center">
                          <div class="col-5 d-flex justify-content-center align-items-center">
                            <button class="btn btn-info mb-5">Confirm Password</button>
                          </div>
                        </div>
                </div>
              </div>   
          </form>
        </div>
  </div>
</div> 
</section>
 
@endsection
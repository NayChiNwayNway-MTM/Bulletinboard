@extends('layouts.master')
@section('content')
    <div class="container col-md-6 ">
      <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
          <div class="row ">
            <div class="col-xl-10">
              <div class="card rounded-3 text-black">
                <div class="row">
                  <div class="col">
                    <div class="card-body p-md-5 mx-md-4">
                      <div class="text-center">
                        <img src="{{asset('uploads/bulletinboard.png')}}"
                          style="width: 185px;" alt="logo">
                      </div>
                      <form action="{{route('userlogin')}}" method="post" class="mt-5">
                      @csrf
                      @if(session('reset_pass'))
                      <div class="alert alert-success" id="alert">
                        {{session('reset_pass')}}
                      </div>
                      @endif
                        <h4 class="mb-3">Please login to your account</h4>
                        <div data-mdb-input-init class="form-outline mb-4">
                          <label class="form-label" for="form2Example11">Email Address:<span class="text-danger">&#42;</span></label>
                          <input type="email" id="form2Example11" class="form-control"  name="email" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                          <label class="form-label" for="form2Example22">Password:<span class="text-danger">&#42;</span></label>
                          <input type="password" id="form2Example22" class="form-control" name="password"/>
                        </div>
                        <div class="text-center pt-1 mb-3 pb-1">
                          <a class="" href="{{route('forgetpassword')}}">Forgot password?</a>
                        </div>
                        <div class="row mb-3">
                          <label for="" class="col-3 col-form-label"></label>
                            <div class="col-sm-8"><button class="btn btn-primary col-md-12">Login</button></div>  
                          </div>
                        <div class="d-flex align-items-center justify-content-center pb-4">
                          <p class="mb-0 me-2">Don't have an account?</p>
                          <a href="{{route('signup')}}" class="link-underline link-underline-opacity-0">Create account?
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            </svg>
                          </a>
                        </div>

                      </form>

                    </div>
                  </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
</section>
    </div>
    

@endsection
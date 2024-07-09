@extends('layouts.nav')
@section('content')
<section class="background">
<div class="container col-md-7">
        
      <section class=" gradient-form">
     
        <div class="container py-5  mt-5">
          <div class="row ">
        
            <div class="col-xl-12">
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
                       
                        <div class="row mb-5">
                          <label for="" class="col-3 form-label">Email Address:<span class="text-danger">&#42;</span></label>
                          <div class="col-sm-8"><input type="text" class="form-control" name="email"></div>
                        </div>
                        <div class="row mb-5">
                              <label for="password" class="col-3 col-form-label">Password: <span class="text-danger">&#42;</span></label>
                              <div class="col-sm-8 password">
                                  <input type="password" class="form-control" id="password" name="password">
                                  <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                              </div>

                        </div>

                        <div class="row mb-5">
                          <div class="col-3"></div>
                          <div class="col-md-8">
                            <div class="d-flex justify-content-around align-items-center mb-4">
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="">
                                <label for="" class="form-check-label">Remember me</label>
                              </div>
                              <a href="{{route('forget.password.get')}}" class="link-underline link-underline-opacity-0">Forgot passwords?</a>
                            </div>
                          </div>       
                        </div>
                        <div class="row mb-5 justify-content-center align-items-center">
                          <div class="col-4"></div>
                            <div class="col-sm-7 justify-content-center align-items-center">
                                <button class="btn btn-primary col-md-6">Login</button>
                            </div>
                        </div>
                        <div class="row text-center mt-5">
                          <a href="{{route('signup')}}" class="link-underline link-underline-opacity-0">Create account?
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            </svg>
                          </a>
                        </div>
                    `</form> 
                    </div>
                  </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
    
</section>
   

@endsection
@if(Session::has('reset_pass'))
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                   
                    message: `{{ Session::get('reset_pass') }}`
                });
            });
         </script>
@elseif(Session::has('message'))
<!--password change come from modelusersubmit_reset_password-->
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                   
                    message: `{{ Session::get('message') }}`
                });
            });
         </script>
@elseif(Session::has('incorrect'))
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.show({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom-danger',
                   
                    message: `{{ Session::get('incorrect') }}`
                });
            });
         </script>  
        
  @endif

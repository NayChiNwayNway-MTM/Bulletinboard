@extends('layouts.nav')
@section('content')
<section class="background">
<div class="mask d-flex align-items-center  pt-5">
    <div class="container mt-5">
    
      <div class="row d-flex justify-content-center align-items-center ">
   
        <div class="col-10">
          <div class="card" >
            <div class="card-body p-5">
              <h2 class="text-primary text-center mb-5">Register</h2>
                <form action="{{route('registration')}}" method="post" class="" enctype="multipart/form-data">
                  @csrf      
                  <div class="row d-flex mb-5">
                    <div class="col-3 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                          <span class="text-danger ">
                          {{ $errors->first('nameerror') }}
                            @error('name')
                              {{$message}}
                            @enderror
                          </span>
                      </div>
                    </div>   
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">E-Mail Address<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="email" name="email" class="form-control" value="{{old('email')}}">
                          <span class="text-danger ">
                          {{ $errors->first('error') }}
                            @error('email')
                              {{$message}}
                            @enderror
                          </span>
                      </div>
                    </div>   
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8 password">
                        <input type="password" name="password" id="password" class="form-control password" value ="{{old('password')}}">
                        <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                      </div>
                      <span class="text-danger error">
                              @error('password')
                                {{$message}}
                              @enderror
                      </span>
                    </div>  
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Confirm Password<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8 password">
                        <input type="password" name="confirmpass" id="con_password" class="form-control" value="{{old('confirmpass')}}">
                        <i class="far fa-eye eyeicon" id="con_togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                      </div>
                      <span class="text-danger error ">
                          @error('confirmpass')
                            {{$message}}
                          @enderror
                      </span>
                    </div>   
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Type</label></div>
                      <div class="col-8">
                        <select name="type" id="" class="form-select" @if(auth()->user()->type == 1) disabled @endif>
                          <option value="user">User</option>
                          <option value="admin">Admin</option>          
                        </select>
                      </div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Phone</label></div>
                      <div class="col-8"><input type="text" name="phone" class="form-control" value="{{old('phone')}}"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end" style="right: 0;">Date of Birth</label></div>
                      <div class="col-8"><input type="date" name="dob" class="form-control" value="{{old('dob')}}"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end" style="right: 0;">Address</label></div>
                      <div class="col-8"><input type="text" name="address" class="form-control" value="{{old('address')}}"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Profile <span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="file" name="profile" class="form-control" value="{{old('profile')}}">
                          <span class="text-danger ">
                                @error('profile')
                                  {{$message}}
                                @enderror
                          </span>
                      </div>
                    </div>
                    <div class="row d-flex justify-content-around align-item-center mt-3 mb-5">
                        <div class="col-sm-6 text-center">
                          <button class="btn btn-info col-5 mx-2">Register</button>
                          <form action="" method="post">
                            @csrf 
                            <button class="btn btn-primary col-5 mx-2" type="reset">Clear</button>
                          </form>
                        </div>        
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<img src="{{asset('uploads/page_top.png')}}" alt="page top" class="pagetop" id="scrolltop" onclick="scrollToTop()">
</section>
<script>
  //start for page top
  function scrollToTop() {
      window.scrollTo({
          top: 0,
          behavior: 'smooth' // Smooth scroll behavior
      });
    }
    window.onscroll = function(){scrollfunction();}
      function scrollfunction(){
        if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
          document.getElementById('scrolltop').style.display = 'block';
        } else{
          document.getElementById('scrolltop').style.display ='none';
        }
    }
    //end for page top
</script>
@endsection

@if(Session::has('register'))
          <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                   
                    message: `{{ Session::get('register') }}`
                });
            });
         </script>  
@endif  
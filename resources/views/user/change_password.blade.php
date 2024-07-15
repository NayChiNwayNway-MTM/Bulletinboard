@extends('layouts.nav')
@section('content')
<section class="background">
<div class="container margin">
<div class="card m-auto mt-5" style="width: 60rem;">
      <div class="card-body justify-content-center align-items-center">
    <form action="{{route('changedpassword')}}" method="post" class="">
        @csrf 
     
                <div class="row">
          <header><h2 class="text-center text-primary">Change Password?</h2></header>
        </div>
        <div class="row d-flex mt-3">
          <div class="col-4 "><label for="" class="form-label float-end">Current Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-6 password">
            <input type="password" name="cur_pass" id="password" class="form-control"
             value="{{old('cur_pass')}}">
            <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip"
             data-bs-placement="top" title="Show Password"></i>
          </div>  
          <span class="text-danger changepasserror">
                @error('cur_pass')
                  {{$message}}
                @enderror
              </span>
                   
        </div>
        <div class="row d-flex mt-3">
          <div class="col-4 "><label for="" class="form-label float-end">New Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-6 password">
            <input type="password" name="new_pass" id="new_password" class="form-control"
             value="{{old('new_pass')}}">
            <i class="far fa-eye eyeicon" id="new_togglePassword" data-bs-toggle="tooltip"
             data-bs-placement="top" title="Show Password"></i>
          </div>     
            <span class="text-danger changepasserror ">
                @error('new_pass')
                  {{$message}}
                @enderror
              </span>   
        </div>
        <div class="row d-flex mt-3">
          <div class="col-4 "><label for="" class="form-label float-end">New Confirm Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-6 password_new">
          <input type="password" name="con_new_pass" id="con_password" class="form-control"
           value="{{old('con_new_pass')}}">
            <i class="far fa-eye eyeicon" id="con_togglePassword" data-bs-toggle="tooltip"
             data-bs-placement="top" title="Show Password"></i>
            
          </div>   
              <span class="text-danger changepasserror">
                @error('con_new_pass')
                  {{$message}}
                @enderror
              </span>        
        </div>
        <div class="row mt-4 justify-content-center align-items-center">
            <div class="col-6 d-flex justify-content-center align-items-center mb-5">
                <button class="btn btn-primary">Update Password</button>
            </div>
        </div>
        
    </form>
</div>
</div>
</div>
</section>

@endsection

@if(Session::has('error'))
          <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.show({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom-danger',
                   
                    message: `{{ Session::get('error') }}`
                });
            });
         </script>  
@endif  
 
@extends('layouts.nav')
@section('content')
<section class="background">
<div class="mask d-flex align-items-center h-100 pt-5">
    <div class="container mt-5 h-100 ">
    @if(Session::has('register'))
                              <div class="alert alert-success" role="alert" id='alert'>
                                  {{Session::get('register')}}
                              </div>
    @endif  
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-10">
          <div class="card custom-card" >
            <div class="card-body p-5">
              <h2 class="text-primary text-center mb-5">Register</h2>
                <form action="{{route('registration')}}" method="post" class="" enctype="multipart/form-data">
                  @csrf 
                               
                  <div class="row d-flex mb-5">
                    <div class="col-3 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="text" name="name" class="form-control">
                          <span class="text-danger ">
                            
                            @error('name')
                              {{$message}}
                            @enderror
                          </span>
                      </div>
                    </div>   
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">E-Mail Address<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="email" name="email" class="form-control">
                          <span class="text-danger ">
                          {{session('error')??''}}
                            @error('email')
                              {{$message}}
                            @enderror
                          </span>
                      </div>
                    </div>   
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8 password">
                        <input type="password" name="password" id="password" class="form-control password">
                        <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                          <span class="text-danger ">
                            @error('password')
                              {{$message}}
                            @enderror
                          </span>
                      </div>
                    </div>  
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Confirm Password<span class="text-danger">&#42;</span></label></div>
                      <div class="col-8 password">
                        <input type="password" name="confirmpass" id="con_password" class="form-control">
                        <i class="far fa-eye eyeicon" id="con_togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                        <span class="text-danger ">
                          @error('confirmpass')
                            {{$message}}
                          @enderror
                        </span>
                      </div>
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
                      <div class="col-8"><input type="text" name="phone" class="form-control"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end" style="right: 0;">Date of Birth</label></div>
                      <div class="col-8"><input type="date" name="dob" class="form-control"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end" style="right: 0;">Address</label></div>
                      <div class="col-8"><input type="text" name="address" class="form-control"></div>
                    </div>
                    <div class="row d-flex mb-5">
                      <div class="col-3 "><label for="" class="form-label float-end">Profile <span class="text-danger">&#42;</span></label></div>
                      <div class="col-8">
                        <input type="file" name="profile" class="form-control">
                          <span class="text-danger ">
                                @error('profile')
                                  {{$message}}
                                @enderror
                          </span>
                      </div>
                    </div>
                  <div class="row d-flex justify-content-around align-item-center mt-3 mb-5">
                        <div class="col-sm-6">
                          <button class="btn btn-info col-5">Register</button>
                          <form action="" method="post">
                            @csrf 
                            <button class="btn btn-primary col-5" type="reset">Clear</button>
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

  </div>

</div>
</section>

@endsection
@extends('layouts.nav')
@section('content')
  <!--*****-->
  <section class="background">
  <div class="mask d-flex align-items-center h-100 ">
    <div class="container mt-5 h-100 ">
      <div class="row d-flex justify-content-center align-items-center h-100 mt-5">
        <div class="col-10">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-primary text-center mb-5">SignUp</h2>
              <form action="{{route('signup')}}" method="post" class="mt-5" enctype="multipart/form-data">
                @csrf 
                <div class="row mb-5">
                          <label for="" class="col-3 form-label">Name:<span class="text-danger">&#42;</span></label>
                          <div class="col-sm-8"><input type="text" class="form-control" name="name" value="{{  old('name') }}"  />
                            <span class="text-danger ">
                            {{ $errors->first('nameerror') }}
                              @error('name')
                                {{$message}}
                              @enderror
                            </span>
                        </div>
                </div>
                <div class="row mb-5">
                  <label class="col-3 form-label" for="">Email <span class="text-danger">&#42;</span></label>
                  <div class="col-sm-8"><input type="email" name="email" id="" class="form-control" value ="{{old('email')}}" /> 
                    <span class="text-danger ">
                    {{ $errors->first('error') }}
                      @error('email')
                        {{$message}}
                      @enderror
                    </span> 
                  </div>               
                </div>
                
                <div  class="row mb-5">
                  <label class="col-3 form-label" for="">Password <span class="text-danger">&#42;</span></label>
                  <div class="col-sm-8 password">
                    <input type="password" name="password" id="password" class="form-control" value ="{{old('password')}}"/>
                    <i class="far fa-eye eyeicon" id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                    <span class="text-danger ">
                      @error('password')
                        {{$message}}
                      @enderror
                    </span>  
                  </div>               
                </div>

                <div class="row mb-5">
                  <label class="col-3 form-label" for="">Confirm password <span class="text-danger">&#42;</span></label>
                  <div class="col-sm-8 password">
                    <input type="password" name="confirm-password" id="con_password" class="form-control" value ="{{old('confirm-password')}}" />
                    <i class="far fa-eye eyeicon" id="con_togglePassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Password"></i>
                    <span class="text-danger ">
                      @error('confirm-password')
                        {{$message}}
                      @enderror
                    </span>
                  </div>                           
                </div>
                <div class="row d-flex justify-content-around align-item-center mt-3 mb-3">
                    <div class="col-sm-6">
                      <button class="btn btn-info col-5">Create</button>
                      <form action="" method="post">
                        @csrf 
                        <button class="btn btn-primary col-5" type="reset">Clear</button>
                      </form>
                    </div>        
                </div>

                <p class="text-center text-muted mt-5 mb-0 ">Have already an account? <a href="{{route('login')}}"
                    class="fw-bold text-body"><u>Login here</u></a></p>

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
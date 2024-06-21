@extends('layouts.master')
@section('content')
  <!--*****-->
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100 ">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>
              <form action="{{route('signup')}}" method="post" class="mt-5" enctype="multipart/form-data">
                @csrf 
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example1cg">Your Name <span class="text-danger">&#42;</span></label>
                  <input type="text" name="name" id="form3Example1cg" class="form-control form-control-lg" />
                  <span class="text-danger ">
                    @error('name')
                      {{$message}}
                    @enderror
                  </span>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example3cg">Your Email <span class="text-danger">&#42;</span></label>
                  <input type="email" name="email" id="form3Example3cg" class="form-control form-control-lg" /> 
                  <span class="text-danger ">
                    @error('email')
                      {{$message}}
                    @enderror
                  </span>                
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example4cg">Password <span class="text-danger">&#42;</span></label>
                  <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" />
                  <span class="text-danger ">
                    @error('password')
                      {{$message}}
                    @enderror
                  </span>                 
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example4cdg">Confirm your password <span class="text-danger">&#42;</span></label>
                  <input type="password" name="confirm-password" id="form3Example4cdg" class="form-control form-control-lg" />
                  <span class="text-danger ">
                    @error('confirm-password')
                      {{$message}}
                    @enderror
                  </span>                           
                </div>
                <div class="row d-flex justify-content-around align-item-center mt-3 mb-3">
                    <div class="col-sm-6">
                      <button class="btn btn-info col-6">Create</button>
                      <form action="" method="post">
                        @csrf 
                        <button class="btn btn-primary col-4" type="reset">Clear</button>
                      </form>
                    </div>        
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="#!"
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

@endsection
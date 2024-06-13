@extends('layouts.master')
@section('content')
<div class="container">
    <form action="{{route('resetpassword')}}" method="post" class="border border-primary mt-5">
        @csrf 
        <div class="row"><header><h2 class="bg-success mb-3">Forgot Password?</h2></header></div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">Email<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="text" name="email" class="form-control"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="This top tooltip is themed via CSS variables." value="">
              <span class="text-danger ">
                @error('email')
                  {{$message}}
                @enderror
              </span>
              <div class="row mt-4 mb-3">
                <div class="col-3">
                  <button class="btn btn-success">Reset Password</button>
                </div>
              </div>
          </div>         
        </div>
    </form>
</div>
@endsection
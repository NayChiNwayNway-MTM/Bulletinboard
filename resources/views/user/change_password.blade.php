@extends('layouts.nav')
@section('content')
<div class="container">
    <form action="{{route('changedpassword')}}" method="post" class="mt-5">
        @csrf 
     
                <div class="row">
          <header><h2 class="">Change Password?</h2></header>
        </div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">Current Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="password" name="cur_pass" class="form-control" value="">
              <span class="text-danger ">
                @error('cur_pass')
                  {{$message}}
                @enderror
              </span>
          </div>         
        </div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">New Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="password" name="new_pass" class="form-control" value="">
              <span class="text-danger ">
                @error('new_pass')
                  {{$message}}
                @enderror
              </span>
          </div>         
        </div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">New Confirm Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="password" name="con_new_pass" class="form-control" value="">
              <span class="text-danger ">
                @error('con_new_pass')
                  {{$message}}
                @enderror
              </span>
              <div class="row mt-4">
                <div class="col-3">
                  <button class="btn btn-success">Update Password</button>
                </div>
              </div>
          </div>         
        </div>
    </form>
</div>
@endsection
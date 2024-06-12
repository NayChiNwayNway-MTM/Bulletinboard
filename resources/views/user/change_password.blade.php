@extends('layouts.master')
@section('content')
<header><h2 class="bg-primary">Change Password?</h2></header>
<div class="container">
    <form action="{{route('changedpassword')}}" method="post" class="mt-5">
        @csrf 
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">Current Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="text" name="cur-pass" class="form-control" value="">
              <span class="text-danger ">
                @error('cur-pass')
                  {{$message}}
                @enderror
              </span>
          </div>         
        </div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">New Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="text" name="new-pass" class="form-control" value="">
              <span class="text-danger ">
                @error('new-pass')
                  {{$message}}
                @enderror
              </span>
          </div>         
        </div>
        <div class="row d-flex mt-3">
          <div class="col-2 "><label for="" class="form-label float-end">New Confirm Password<span class="text-danger">&#42;</span></label></div>
          <div class="col-8">
            <input type="text" name="con-new-pass" class="form-control" value="">
              <span class="text-danger ">
                @error('new-con-pass')
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
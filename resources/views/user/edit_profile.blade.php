@extends('layouts.master')
@section('content')
<header><h2 class="bg-success">Edit Profile</h2></header>
<div class="container">
  <form action="" method="post" class="mt-5" enctype="multipart/form-data">
    @csrf     
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="name" class="form-control">
          <span class="text-danger ">
            @error('name')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
    
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">E-Mail Address<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="email" name="email" class="form-control">
          <span class="text-danger ">
            @error('email')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
    
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Type</label></div>
      <div class="col-8">
        <select name="type" id="" class="form-select">
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
      </div>
    </div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Phone</label></div>
      <div class="col-8"><input type="text" name="phone" class="form-control"></div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Date of Birth</label></div>
      <div class="col-8"><input type="date" name="dob" class="form-control"></div>
    </div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Address</label></div>
      <div class="col-8"><input type="text" name="address" class="form-control"></div>
    </div>
    <div class="row d-flex mt-3">
    <div class="col-2 "><label for="" class="form-label float-end mt-3">Old Profile</label></div>
    <div class="col-8">
      <img src="" alt="error" class="rounded-circle" width="200" height="200">
    </div>
  </div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">New Profile</label></div>
      <div class="col-8">
        <input type="file" name="new_profile" class="form-control">
          <span class="text-danger ">
                @error('profile')
                  {{$message}}
                @enderror
          </span>
      </div>
    </div>
    <div class="row mt-3 mb-3">
          <div class="col-2"></div>
          <div class="col-6 d-flex justify-content-between align-item-center">
            <button class="btn btn-info col-2">Edit</button>
            <form action="" method="post">
              @csrf 
              <button class="btn btn-primary col-2" type="reset">Clear</button>
            </form>
            <div class="col-4"><a href="" class="col-4">Change Password</a></div>
          </div>        
    </div>
  </form>
</div>

@endsection
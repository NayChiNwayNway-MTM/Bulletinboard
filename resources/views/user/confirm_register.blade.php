@extends('layouts.master')
@section('content')
<div class="container">
  <form action="{{route('saveregister')}}" method="post" class="border border-primary rounded mt-5" enctype="multipart/form-data">
    @csrf 
    <div class="row"><h2 class="text-center text-primary">Confirm Register</h2></div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="name" class="form-control"  value="{{$users->name}}">
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
        <input type="email" name="email" class="form-control" value="{{$users->email}}">
          <span class="text-danger ">
            @error('email')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Password<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="password" class="form-control" value="{{$users->password}}">
          <span class="text-danger ">
            @error('password')
              {{$message}}
            @enderror
          </span>
      </div>
    </div>
   
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Confirm Password<span class="text-danger">&#42;</span></label></div>
      <div class="col-8">
        <input type="text" name="confirmpass" class="form-control" value="{{$users->confirmpass}}">
        <span class="text-danger ">
          @error('confirmpass')
            {{$message}}
          @enderror
        </span>
      </div>
    </div>
   
    <div class="row d-flex mt-3">
      <div class="col-2 "><label for="" class="form-label float-end">Type</label></div>
      <div class="col-8">
        <select name="type" id="" class="form-select" @if(auth()->user()->type == 1) disabled @endif>
        <option value="user" {{ old(`type`, session(`type`)) ==`user` ? `selected` : `` }}>User</option>
        <option value="admin" {{ old(`type`, session(`type`)) == `admin` ? `selected` : `` }}>Admin</option>
          
        </select>
      </div>
    </div>
  <div class="row d-flex mt-3">
    <div class="col-2 "><label for="" class="form-label float-end">Phone</label></div>
    <div class="col-8"><input type="text" name="phone" class="form-control" value="{{$users->phone}}"></div>
  <div class="row d-flex mt-3">
    <div class="col-2 "><label for="" class="form-label float-end">Date of Birth</label></div>
    <div class="col-8"><input type="date" name="dob" class="form-control" value="{{$users->dob}}"></div>
  </div>
  <div class="row d-flex mt-3">
    <div class="col-2 "><label for="" class="form-label float-end">Address</label></div>
    <div class="col-8"><input type="text" name="address" class="form-control" value="{{$users->address}}"></div>
  </div>
  <div class="row d-flex mt-3">
    <div class="col-2 "><label for="" class="form-label float-end mt-3">Profile</label></div>
    <div class="col-8">
    <img src="{{asset($imagePath)}}" alt="error" class="rounded-circle" width="200" height="200">
        <span class="text-danger ">
              @error('file')
                {{$message}}
              @enderror
        </span>
    </div>
  </div>
  <div class="row d-flex justify-content-around align-item-center mt-3 mb-3">
        <div class="col-sm-6">
          <button class="btn btn-info col-6">Confirm</button>
          <form action="" method="post">
            @csrf 
            <button class="btn btn-primary col-4" type="reset">Cancel</button>
          </form>
        </div>        
    </div>
  </form>
  </div>
@endsection
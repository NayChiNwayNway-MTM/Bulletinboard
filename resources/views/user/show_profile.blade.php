@extends('layouts.nav')
@section('content')

<div class="container">
  <!--////-->
  <div class="card m-auto mt-5" style="width: 30rem;">
  <div class="card-body">
  <form action="{{route('editprofile',$user_data->id)}}" method="get" class="">
      <div class="row"><header><h2 class="">Profile</h2></header></div>
      @csrf 
      @if(Session::has('profileedited'))
      <div class="alert alert-success" role="alert" id="alert">
        {{Session::get('profileedited')}}
      </div>
      @endif
      <div class="row">
        <div>
        <img class="" src="{{ asset($user_data->profile ?? 'default/default-profile.jpg') }}" alt="Profile Image" id="profile">
        </div>
        <div class="">
          <div class="row">
            <div class="col"><label for="" class="form-label">Name</label></div>
            <div class="col"><label for="" class="form-label">{{$user_data->name}}</label></div>
          </div>
          <div class="row mt-2">
            <div class="col"><label for="" class="form-label">Type</label></div>
            <div class="col"><label for="" class="form-label">{{ $user_data->type == 1 ? 'User' : 'Admin' }}</label></div>
          </div>
          <div class="row mt-2">
            <div class="col"><label for="" class="form-label">Email</label></div>
            <div class="col"><label for="" class="form-label">{{$user_data->email}}</label></div>
          </div>
          <div class="row mt-2">
            <div class="col"><label for="" class="form-label">Phone</label></div>
            <div class="col"><label for="" class="form-label">{{$user_data->phone}}</label></div>
          </div>
          <div class="row mt-2">
            <div class="col"><label for="" class="form-label">Date of Birth</label></div>
            <div class="col"><label for="" class="form-label">{{$user_data->dob}}</label></div>
          </div>
          <div class="row mt-2">
            <div class="col"><label for="" class="form-label">Address</label></div>
            <div class="col"><label for="" class="form-label">{{$user_data->address}}</label></div>
          </div>
          <div class="row mt-2 mx-auto text-center">
            <div class="col-10"><button class="btn btn-primary col-7">Edit</button></div>        
          </div>       
      </div>
    </form>  
   
  </div>
</div>
  <!--/////-->
</div>
@endsection
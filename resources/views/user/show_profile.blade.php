@extends('layouts.nav')
@section('content')

<div class="container">
    <form action="{{route('editprofile')}}" method="post" class="border border-primary mt-5">
      <div class="row"><header><h2 class="bg-success">Profile</h2></header></div>
      @csrf 
      <div class="row mt-5">
        <div class="col-4">
          <img src="" alt="Profile Image">
        </div>
        <div class="col-8">
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Name</label></div>
            <div class="col"><label for="" class="form-label">Name</label></div>
          </div>
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Type</label></div>
            <div class="col"><label for="" class="form-label">Type</label></div>
          </div>
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Email</label></div>
            <div class="col"><label for="" class="form-label">Email</label></div>
          </div>
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Phone</label></div>
            <div class="col"><label for="" class="form-label">Phone</label></div>
          </div>
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Date of Birth</label></div>
            <div class="col"><label for="" class="form-label">Date of Birth</label></div>
          </div>
          <div class="row mt-3">
            <div class="col"><label for="" class="form-label">Address</label></div>
            <div class="col"><label for="" class="form-label">Addresse</label></div>
          </div>
          <div class="row mt-3 mx-auto text-center">
            <div class="col-4"><button class="btn btn-success col-4">Edit</button></div>        
          </div>       
      </div>
    </form>            
  </div>
</div>
@endsection
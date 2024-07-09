@extends('layouts.nav')
@section('content')
<section class="background">
  <div class="container margin">
    
    <div class="card m-auto mt-5" style="width: 40rem;">
    <div class="card-body">
    <form action="{{route('editprofile',$user_data->id)}}" method="get" class="">
        <div class="row"><header><h2 class="">Profile</h2></header></div>
        @csrf 
        <div class="row">
          <div class="text-center">
            <img class="" src="{{ asset($user_data->profile ?? 'default/default-profile.jpg') }}" alt="Profile Image" id="profile">
          </div>
        </div>
          <div class="row">
            <div class="row">
              <div class="col-6"><label for="" class="form-label">Name</label></div>
              <div class="col-6"><label for="" class="form-label">{{$user_data->name}}</label></div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label for="" class="form-label">Type</label></div>
              <div class="col-6"><label for="" class="form-label">{{ $user_data->type == 1 ? 'User' : 'Admin' }}</label></div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label for="" class="form-label">Email</label></div>
              <div class="col-6"><label for="" class="form-label">{{$user_data->email}}</label></div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label for="" class="form-label">Phone</label></div>
              <div class="col-6"><label for="" class="form-label">{{$user_data->phone}}</label></div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label for="" class="form-label">Date of Birth</label></div>
              <div class="col-6"><label for="" class="form-label">{{$user_data->dob}}</label></div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label for="" class="form-label">Address</label></div>
              <div class="col-6"><label for="" class="form-label">{{$user_data->address}}</label></div>
            </div>
            <div class="row mt-2 mx-auto text-center d-flex justify-content-center align-item-center">
              <div class="col-10"><button class="btn btn-primary col-7">Edit</button></div>        
            </div>       
        </div>
      </form>  
    
    </div>
  </div>
</section>


</div>
@endsection
@if(Session::has('profileedited'))
          <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                   
                    message: `{{ Session::get('profileedited') }}`
                });
            });
         </script>  
@endif 
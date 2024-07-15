@extends('layouts.nav')
@section('content')
<section class="background">
  <div class="container margin">
    <div class="card m-auto mt-5" style="width: 60rem;">
      <div class="card-body justify-content-center align-items-center">
        <form action="{{route('updateprofile',$user->id)}}" method="post" class="col-11 m-auto" enctype="multipart/form-data">
          @csrf     
          <div class="row">
            <header><h2 class="text-center text-primary">Edit Profile</h2></header>
          </div>
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">Name<span class="text-danger">&#42;</span></label></div>
            <div class="col-8">
              <input type="text" name="name" class="form-control" value="{{$user->name}}">
                <span class="text-danger ">
                  @error('name')
                    {{$message}}
                  @enderror
                </span>
            </div>
          </div>
          
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">E-Mail Address<span class="text-danger">&#42;</span></label></div>
            <div class="col-8">
            <input type="email" name="email" class="form-control" value="{{$user->email}}">
                <span class="text-danger ">
                  @error('email')
                    {{$message}}
                  @enderror
                </span>
            </div>
          </div>
          
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">Type</label></div>
            <div class="col-8">
              <select name="type" id="" class="form-select" @if(auth()->user()->type == 1) disabled @endif>
              <option value="user">User</option>
                <option value="admin">Admin</option>
              
              </select>
            </div>
          </div>
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">Phone</label></div>
            <div class="col-8"><input type="text" name="phone" class="form-control" value="{{$user->phone}}"></div>
          </div>
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">Date of Birth</label></div>
            <div class="col-8"><input type="date" name="dob" class="form-control"
             value="{{$user->dob}}" max="{{now()->format('Y-m-d')}}"></div>
          </div>
          <div class="row d-flex mt-5">
            <div class="col-3 "><label for="" class="form-label float-end">Address</label></div>
            <div class="col-8"><input type="text" name="address" class="form-control" value="{{$user->address}}"></div>
          </div>
          <div class="row d-flex mt-5">
          <div class="col-3"><label for="" class="form-label float-end mt-3">Old Profile</label></div>
          <div class="col-8">
            <img src="{{asset($user->profile)}}" alt="error" class="rounded-circle" width="200" height="200">
          </div>
          </div>
          <div class="row d-flex mt-5">
            <div class="col-3"><label for="" class="form-label float-end">New Profile</label></div>
            <div class="col-8">
              <input type="file" name="new_profile" class="form-control">
                <span class="text-danger ">
                      @error('profile')
                        {{$message}}
                      @enderror
                </span>
            </div>
          </div>
          <div class="row mt-5 mb-3">
                <div class="col-2"></div>
                <div class="col-10 d-flex justify-content-center align-item-center">
                  <button class="btn btn-info col-2 me-5">Confirm</button>
                  <form action="" method="post">
                    @csrf 
                    <button class="btn btn-primary col-2 me-5" type="reset">Clear</button>
                  </form>
                  <div class="col-4"><a href="{{route('changepassword')}}" class="col-4 me-5">Change Password</a></div>
                </div>        
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<img src="{{asset('uploads/page_top.png')}}" alt="pagetop" class="pagetop" id="scrolltop" onclick="scrollToTop()">
@endsection
<script>
//start page top
    function scrollToTop(){
          window.scrollTo({
            top:0,
            behavior:'smooth'
          })
        }
        window.onscroll = function(){
          if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20 ){
            document.getElementById('scrolltop').style.display = 'block'
          }else{
            document.getElementById('scrolltop').style.display = 'none'
          }
  }
       //end page top
</script>
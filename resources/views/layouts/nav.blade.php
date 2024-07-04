<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/css/common.css')}}">

  <title>BulletinBoard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg px-3">
  @guest
  <div class="container-fluid">
    <a class="navbar-brand bulletin-board-link" href="{{route('login')}}">
      Bulletin_Board</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav_link">
        <li class="nav-item">
          <a href="{{route('postlist')}}" class="nav-link nav_link {{request()->routeIs('postlist') ? 'active' :''}} !important " >Posts</a>
        </li>
      </ul>
      <form class="d-flex">
        <ul class="navbar-nav me-auto mb-lg-0">
          <li class="link-offset-2 link-underline link-underline-opacity-0 py-2 nav_link ">
              <a href="{{route('login')}}"
            class="link-offset-2 link-underline link-underline-opacity-0 px-3 register {{request()->routeIs('login') ? 'active' :''}} ">Login</a>
          </li>
          <li class="link-offset-2 link-underline link-underline-opacity-0 py-2 nav_link">
              <a href="{{route('signup')}}"
            class="link-offset-2 link-underline link-underline-opacity-0 px-3 register {{request()->routeIs('signup')? 'active':''}}">Sign Up</a>
          </li>
        </ul>
      </form>
    </div>
  </div>
  @endguest
  <!--*****************-->
  @auth
  <div class="container-fluid">
    <a class="navbar-brand bulletin-board-link" href="{{route('logout')}}">Bulletin_Board</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item nav_link">
          <a class="nav-link {{ request()->routeIs('user','user_card','search_user','search_card') ? 'active' : '' }}" aria-current="page" 
            href="{{route('user')}}">Users</a>
        </li>
        @if(auth()->user()->type == 1)
        <li class="nav-item nav_link mx-5">
          <a class="nav-link {{ request()->routeIs('postlist','card_view','search','search_cardView') ? 'active' : '' }}"
             href="{{route('postlist')}}">Posts</a>
        </li>
        @endif
        <li class="nav-item nav_link mx-5 allpost">
          <a class="nav-link {{ request()->routeIs('all_postlist','all_postlist_card','search_allpost_table','search_allpost_card')? 'active' : ''}}"
           href="{{route('all_postlist')}}">All Posts</a>
        </li>
        @if(auth()->user()->type == 0)
        <li class="nav-item nav_link mx-5 allpost">
          <a class="nav-link {{ request()->routeIs('barchart')? 'active':''}}"
           href="{{route('barchart')}}">Chart</a>
        </li>
        @endif
      </ul>
      <form class="d-flex">
        <ul class="navbar-nav me-auto mb-lg-0">
          <li class="link-offset-2 link-underline link-underline-opacity-0 py-2 mx-2"><a href="{{route('register')}} "
           class="link-offset-2 link-underline link-underline-opacity-0 px-3 register">Create User</a></li>
           <li>
            <a href="{{route('profile',auth()->user()->id)}}"><img src="{{ asset(auth()->user()->profile)}}" alt="profile" style="width: 50px; height: 50px; border-radius: 50%;"
                      class="rounded-circle img-thumbnail custom-img-thumbnail" 
                      data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="profile">
            </a>
            </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{auth()->user()->name}}            
            </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('profile',auth()->user()->id)}}">Profile</a></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Log Out</a></li>
          </ul>
        </ul>
      </form>
    </div>
  </div>
  
   <!--*****************-->
   @endauth
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@yield('content')
@include('layouts.footer')

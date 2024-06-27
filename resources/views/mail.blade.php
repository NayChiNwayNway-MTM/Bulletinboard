@extends('layouts.master')
@section('content')
<h1>Welcome to Bulletin_Board <span>{{$mailData['name']}}</span></h1>
<p>Your username is:{{$mailData['name']}}</p>
<a href="{{route('resetpassword.get',['token'=>$mailData['token'],'email'=>$mailData['email']])}}">Link Reset</a>
<p>click the link and reset password</p>
<p>Thanks for joining and have a great day.</p>
@endsection
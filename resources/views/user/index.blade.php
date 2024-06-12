@extends('layouts.master')
@section('content')
<header><h2 class="bg-success p-2">User List</h2></header>
<section>
<div class="container">
      <form action="" method="post" class="mt-5">
          <div class="row d-flex">
            <div class="col"><label for="" class="form-label float-end">Name:</label></div>
            <div class="col"><input type="text" name="name" class="form-control"></div>
            <div class="col"><label for="" class="form-label float-end">Email:</label></div>
            <div class="col"><input type="email" name="email" class="form-control"></div>
            <div class="col"><label for="" class="form-label float-end">From:</label></div>
            <div class="col"><input type="date" name="from" class="form-control"></div>
            <div class="col"><label for="" class="form-label float-end">to:</label></div>
            <div class="col"><input type="date" name="to" class="form-control"></div>
            <div class="col"><button class="btn btn-success">Search</button></div>
          </div>        
      </form> 
      <table class="table table-striped mt-5 table-primary ">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created User</th>
            <th>Type</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Created_date</th>
            <th>Updated_date</th>
            <th>Operation</th>
          </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{(($users->currentPage()*5)-5)+$loop->iteration}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->created_user_id}}</td>
              <td>{{$user->type}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->dob}}</td>
              <td>{{$user->address}}</td>
              <td>{{$user->created_at}}</td>
              <td>{{$user->updated_at}}</td>
              <td><a href="" class="btn btn-danger">Delete</a></td>
            </tr>
            @endforeach
        </tbody>
      </table> 
      {!!$users->links()!!}
</div>   

</section>
@endsection
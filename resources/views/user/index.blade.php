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
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table> 
</div>   

</section>
@endsection
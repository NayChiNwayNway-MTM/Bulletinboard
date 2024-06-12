@extends('layouts.nav')
@section('content')
  <header><h1>Post List</h1></header> 
  <section>
    <div class="container">
      <div class="row float-end mb-5">
          <form action="" method="post">
            <div class="d-flex flex-row">
              @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                  {{Session::get('success')}}
                </div>
              @endif
              <lavel class="form-label d-block m-2">KeyWords:</lavel>
              <div class="col-xs-8  m-2">
                <input type="text" class="form-control">
              </div>
              <div class="col-xs-4"><button class="btn btn-success m-2">Search</button></div> 
                <button class="btn btn-success m-2">Create</button>
                <button class="btn btn-success m-2">Upload</button>
                <button class="btn btn-success m-2">Download</button> 
              </div>                   
          </form>
      </div>
      <div class="row d-block">
        <table class="table table-striped table-primary ">
          <thead>
            <tr>
              <th>Post Title</th>
              <th>Post Description</th>
              <th>Posted User</th>
              <th>Posted Date</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody>
              @foreach($postlist as $list)
              <tr>
                <td><a href="#">{{$list->title}}</a></td>
                <td>{{$list->description}}</td>
                @if($list->create_user_id == 0)
                  <td>Admin</td>
                @else
                  <td>User</td>
                @endif
                <td>{{$list->created_at}}</td>
                <td>
                  <a href="{{route('post.edit',$list->id)}}" class="btn btn-warning">Edit</a>
                  <a href="#" class="btn btn-danger">Delete</a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {!! $postlist->links() !!}
      </div>
    </div>
  </section>
@endsection
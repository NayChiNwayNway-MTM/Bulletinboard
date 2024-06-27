@extends('layouts.nav')
@section('content')
<div class="container mt-5">
    <div class="card text-center upload">
      <div class="card-body">
        <h5 class="card-title">Upload CSV File</h5>        
        <form action="{{route('uploadedpost')}}" method="post" class="mt-5" enctype="multipart/form-data">
          @csrf
          <div class="row d-flex">
            <div class="col-4">
              <label for="" class="form-label float-end">CSV File</label>
            </div>     
            <div class="col-6">
              <input type="file" class="form-control col-6" name="csvfile">
              <span class="text-danger">
              {{session('error')??''}}
                @error('csvfile')
                    {{ $message }}
                @enderror
              </span>         
              <div class="row d-flex  mt-5 mb-5">
                <button class="btn btn-info col-4 m-2">Upload</button>
                <button class="btn btn-primary col-4 m-2 ty" type="reset">Clear</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
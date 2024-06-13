@extends('layouts.nav')
@section('content')
<header><h2 class="bg-success">Upload CSV File</h2></header>
<div class="container">
    <form action="{{route('uploadedpost')}}" method="post" class="mt-5">
      @csrf
      <div class="row d-flex">
        <div class="col-4">
          <label for="" class="form-label float-end">CSV File</label>
        </div>
        <div class="col-6">
          <input type="file" class="form-control col-6" name="csvfile">
          <div class="row d-flex mt-5">
            <button class="btn btn-success col-4 m-2">Upload</button>
            <button class="btn btn-info col-4 m-2 ty" type="reset">Clear</button>
          </div>
        </div>
      </div>
    </form>
</div>
@endsection
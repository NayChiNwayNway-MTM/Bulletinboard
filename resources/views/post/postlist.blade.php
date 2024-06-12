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
              <tr id='{{$list->id}}'>
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
                  <form action="" method="get" class="btn ">
                    @csrf 
                    @method('DELETE')
                    <button class="btn btn-danger m-0 delete">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {!! $postlist->links() !!}
      </div>
    </div>
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <p><strong>ID:</strong> <span id="postid"></span></p>
                <p><strong>Title:</strong> <span id="posttitle"></span></p>
                <p><strong>Description:</strong> <span id="postdescription"></span></p>
                <p><strong>Status:</strong> <span id="poststatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                
            </div>
        </div>
    </div>
</div>
  </section>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    $(document).ready(function () {
        $('.delete').on('click', function (e) {
            let tr = this.parentElement.parentElement.parentElement;
            let id= tr.getAttribute('id');
            //$('#deleteModal').modal('show');
            //console.log(id);
           e.preventDefault();
           $.ajax({
            method:`post`,
            url:`approve/${id}`,
            dataType:'json',
            success:function(response){
              var post=response.post;
             // console.log(post);
              if(response.success){
                  //console.log(posts);
                  $('#postModal').modal('show');
                  // Update modal content with post details
                  $('#postid').text(post.id);
                  $('#posttitle').text(post.title);
                  $('#postdescription').text(post.description);
                  if(post.status ==1){
                    $('#poststatus').text('Active');
                  }
                  else{
                    $('#poststatus').text('Inactive');
                  }
              }             
            }
           });
        });

        //delete post from database
        $('#confirmDelete').on('click', function() {
          console.log("tr");
        let tr = this.parentElement.parentElement.parentElement;
        //let id= tr.getAttribute('id');
        console.log(tr);
        //$.ajax({
        //    url: '/deleteItem/' + itemId,
        //    type: 'DELETE',
        //    success: function(response) {
        //        // Handle success response
        //        alert(response.message);
        //        // Optionally, reload the page or update the UI
        //    }
        //});
      });
    });
</script>

@endsection

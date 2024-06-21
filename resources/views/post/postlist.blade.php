@extends('layouts.nav')
@section('content')

  <header><h1 class="px-5 py-2">Post List</h1></header> 
  <section>
    <!--start container-->
    <div class="container">
    @if(Session::has('success'))
                <div class="alert alert-success" role="alert" id='alert'>
                  {{Session::get('success')}}
                </div>
    @elseif(Session::has('postedites'))
                <div class="alert alert-success" role="alert" id='alert'>
                  {{Session::get('postedites')}}
                </div>
    @endif
      <div class="row float-end mb-5">
          <form action="" method="get" id="form">
            <div class="d-flex flex-row">       
              <lavel class="form-label d-block m-2">KeyWords:</lavel>
                  <div class="col-xs-8  m-2">
                  <input type="text" class="form-control" name="text" id='text'>
                </div>
                  <div class="col-xs-4"><button id="searchpost" class="btn btn-primary m-2">Search</button></div>
                <button  id="createpost" class="btn btn-primary m-2">Create</button>
                <button id="uploadpost" class="btn btn-primary m-2">Upload</button>
                <button id="downloadpost" class="btn btn-primary m-2">Download</button> 
              </div>                   
          </form>
      </div>
      <div class="row d-block">
        <table class="table table-striped table-primary " id="postTable">
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
                    <td><label class="form-label text-primary" id="post_detail">{{$list->title}}</label></td>
                    <td>{{$list->description}}</td>
                    @if($list->created_user_id == 0)
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
        
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="paginationLinks">
                  
                    {!! $postlist->links() !!}
                  
                    </ul>
                    <div id="paginationLinksContainer">
                         <!-- Pagination links will be inserted here -->
                  </div>
                </nav>
            </div>
        </div>
      </div>
    </div>
    <!--end container-->
    <!--start modal-->
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
    <!--end modal-->
     <!--start post detail modal-->
     <div class="modal fade" id="postdetailModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postdetailModalLabel">Post Detail</h5>
                    <div class="col-md-8"></div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <hr>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                      <div class="col-5"><strong>Title:</strong></div>
                      <div class="col-5"><span id="title" class="text-info"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Status:</strong></div>
                      <div class="col-5"><span id="status" class="text-info"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Description:</strong></div>
                      <div class="col-5"><span id="des" class="text-info"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Created Date:</strong></div>
                      <div class="col-5"><span id="created_date" class="text-info"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Created User:</strong></div>
                      <div class="col-5"><span id="created_user" class="text-info"></span></div>
                    </div><div class="row mt-4">
                      <div class="col-5"><strong>Updated Date:</strong></div>
                      <div class="col-5"><span id="updated_date" class="text-info"></span></div>
                    </div><div class="row mt-4">
                      <div class="col-5"><strong>Updated User:</strong></div>
                      <div class="col-5"><span id="updated_user" class="text-info"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!--end post detail modal-->
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //start post delete 
    $(document).ready(function () {
        $('.delete').on('click', function (e) {
            let tr = this.parentElement.parentElement.parentElement;
            let id= tr.getAttribute('id');
            //console.log(id);
           e.preventDefault();
           $.ajax({
            method:`post`,
            url:`delete/${id}`,
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
                  //delete post from database
                  $('#confirmDelete').on('click', function() {
                      //console.log(id);
                      $.ajax({
                          url: `postlist/deletedpost/${id}`,
                          type: `delete`,
                          success: function(response) {
                              //alert(response.message);
                              location.reload();
                          }
                      });
                    });
              }             
            }
           });
        });
    });
    //end post delete

    $(document).ready(function(){
      var form=$('#form');
      $('#uploadpost').on('click',function(){
        form.attr('action','{{url("/uploadpost")}}')
      });

      $('#createpost').on('click',function(){
        form.attr('action','{{url("/createpost")}}');
      });
      
      $('#downloadpost').on('click',function(){
        form.attr('action','{{url("/posts/export")}}');
      });
    });
  //========================================
    //for search action
    $(document).ready(function() {
        // Function to load posts with pagination
        function loadPosts(url) {
            $.ajax({
                method: 'post',
                url: url,
                dataType: 'json',
                success: function(response) {
                    var tableBody = $('#postTable tbody');
                    tableBody.empty();

                    if (response.posts.length > 0) {
                        $.each(response.posts, function(index, post) {
                            var row = $('<tr>', { id: post.id });

                            row.append($('<td>').text(post.title));
                            row.append($('<td>').text(post.description));
                            if(post.created_user_id == 0){
                              row.append($('<td>').text("Admin"));
                            }else{
                              row.append($('<td>').text("User"));
                            }
                          
                            row.append($('<td>').text(post.created_at));

                            var td = $('<td>');
                            var editLink = $('<a>', {
                                href: `post/${post.id}/edit`,
                                class: 'btn btn-warning',
                                text: 'Edit'
                            });
                            var deleteButton = $('<button>', {
                                type: 'button',
                                class: 'btn btn-danger delete mx-2',
                                text: 'Delete'
                            });

                            td.append(editLink).append(deleteButton);
                            row.append(td);
                            tableBody.append(row);
                        });

                        // Update pagination links
                        $('#paginationLinks').remove();
                        $('#paginationLinksContainer').html(response.pagination);
                    } else {
                        // Display no posts found message
                        tableBody.append($('<tr>').append($('<td>', {
                            colspan: 5,
                            text: 'No posts found.'
                        })));
                    }
                }
            });
        }

        // start search
        $('#searchpost').on('click', function(e) {
            e.preventDefault();
            var text = $('#text').val();
            loadPosts(`search/${text}`);
        });


        $(document).on('click', '#paginationLinksContainer .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            loadPosts(url);
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).closest('tr').attr('id');

            $.ajax({
                method: 'post',
                url: `delete/${id}`,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var post = response.post;
                        $('#postModal').modal('show');

                        // Update modal content with post details
                        $('#postid').text(post.id);
                        $('#posttitle').text(post.title);
                        $('#postdescription').text(post.description);
                        $('#poststatus').text(post.status == 1 ? 'Active' : 'Inactive');

                        $('#confirmDelete').off('click').on('click', function() {
                            $.ajax({
                                url: `postlist/deletedpost/${id}`,
                                type: 'delete',
                                success: function(response) {
                                    location.reload();
                                }
                            });
                        });
                    }
                }
            });
        });
    });

    //post deail modal box
    $(document).ready(function(){
      $(document).on('click','#post_detail',function(){
        var tr=$(this).closest('tr')
        var id=tr.attr('id')
        $.ajax({
          method:`post`,
          url:`/postdetails/${id}`,
          dataType: 'json',
          success:function(response){
            console.log(response)
            var post=response.postdetail;
            $('#postdetailModal').modal('show')
            $('#title').text(post.title)
            $('#status').text(post.status)
            $('#des').text(post.description)
            $('#created_date').text(post.created_at)
           $('#created_user').text(response.user[0])
            $('#updated_date').text(post.updated_at)
            $('#updated_user').text(response.user)
          }
        })
      })
    })


</script>

@endsection

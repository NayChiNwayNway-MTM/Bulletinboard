@extends('layouts.nav')
@section('content')
  <header><h1>Post List</h1></header> 

  <section>
    <!--start container-->
    <div class="container">
    @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                  {{Session::get('success')}}
                </div>
              @endif
      <div class="row float-end mb-5">
          <form action="" method="get" id="form">
            <div class="d-flex flex-row">           
              <lavel class="form-label d-block m-2">KeyWords:</lavel>
                  <div class="col-xs-8  m-2">
                  <input type="text" class="form-control" name="text" id='text'>
                </div>
                  <div class="col-xs-4"><button id="searchpost" class="btn btn-success m-2">Search</button></div>
                <button  id="createpost" class="btn btn-success m-2">Create</button>
                <button id="uploadpost" class="btn btn-success m-2">Upload</button>
                <button id="downloadpost" class="btn btn-success m-2">Download</button> 
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
                <td><a href="#" class=" link-underline link-underline-opacity-0">{{$list->title}}</a></td>
                <td>{{$list->description}}</td>
                @if($list->created_user_id == 0)
                  <td>Admin</td>
                @else
                    @foreach($user as $us)
                        @if($us->id == $list->created_user_id)
                            <td>{{ $us->name }}</td>
                        @endif
                    @endforeach
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
        form.attr('action','{{url("/downloadpost")}}');
      });
    });
    //post search
    $(document).ready(function(){
      $('#searchpost').on('click',function(e){
        e.preventDefault();
        var txt=document.querySelector('#text');
        var text=txt.value;
        $.ajax({
          method:`post`,
          url:`search/${text}`,
          dataType:'json',
          success:function(response){
            console.log(response);
            var tableBody = $('#postTable tbody');
                tableBody.empty();
            $.each(response.posts, function(index, post){
             var row=document.createElement('tr');
             row.id=post.id;

             var title=document.createElement('td');
             title.textContent=post.title;
             row.appendChild(title);

             var des=document.createElement('td');
             des.textContent=post.description;
             row.appendChild(des);

             var pos_user=document.createElement('td');
             pos_user.textContent=post.created_user_id;
             row.appendChild(pos_user);

             var created_at=document.createElement('td');
             created_at.textContent=post.created_at;
             row.appendChild(created_at);

             var td =document.createElement('td');
              var editLink = document.createElement('a');
              editLink.href=`post/${post.id}/edit`;
              editLink.className = 'btn btn-warning';
              editLink.textContent = 'Edit';
              td.appendChild(editLink);

              var deleteButton = document.createElement('button');
            
              deleteButton.type = 'submit';
              deleteButton.className = 'btn btn-danger delete mx-2';
              deleteButton.textContent = 'Delete';
            
              td.appendChild(deleteButton);

              row.appendChild(td);
              tableBody.append(row);
              var paginationLinks = document.getElementById('paginationLinks');
                if (paginationLinks) {
                    paginationLinks.remove();
                }
              $(document).ready(function () {
                $('.delete').on('click', function (e) {
                    let id = this.parentElement.parentElement.getAttribute('id');
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
                            });//end delete post
                        }             
                      }
                  });
              
                });// end delete
              });
            });//end each loop
          }
        });//end ajax   
        
      });
    
    });
</script>

@endsection

@extends('layouts.nav')
@section('content')
  <section class="background mt-5">
  <header><h3 class="px-5 py-5">All Post List</h3></header> 
    <!--start container-->
    <div class="container">
      @auth    
      <div class="row mb-5">
        <form action="" method="get" id="form" class="float-start">
            
            <div class="row">
                <div class="col-md-12 float-end">
                    <div class="d-flex flex-row align-items-center justify-content-end">
                        <label class="form-label d-block m-2">Keywords:</label>
                        <div class="m-2">
                            <input type="text" class="form-control" name="text" id="text" value="{{ request('text') }}">
                        </div>
                        <div class="m-2">
                            <button id="search_post" class="btn btn-primary">Search</button>
                        </div>
                        <div class="m-2">
                            <button id="createpost" class="btn btn-primary">Create</button>
                        </div>
                        <div class="m-2">
                            <button id="uploadpost" class="btn btn-primary">Upload</button>
                        </div>
                        <div class="m-2">
                            <button id="downloadpost" class="btn btn-primary">Download</button>
                        </div>
                       
                        <div class="m-2">
                          <a href="{{route('all_postlist')}}" class="btn btn-primary" id="ViewBtn">Design</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <label for="page_size" class="me-2">Page Size:</label>
                        <select name="page_size" id="page_size" onchange="this.form.submit()" class="form-select w-auto">
                            <option value="9" {{ request('page_size') == 9 ? 'selected' : '' }}>9</option>
                            <option value="15" {{ request('page_size') == 15 ? 'selected' : '' }}>15</option>
                            <option value="21" {{ request('page_size') == 21 ? 'selected' : '' }}>21</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
      </div>

      @endauth
      <div class="design_container">
        <div class="row d-block">
            @if($postlist->isEmpty())
              <h5 class="text-center mt-3">Post Not Found.</h5>
            @else  
                <!-- start post card-->
                  <div class="container" id="postCard">
                    <div class="row row-cols-1 row-cols-md-3 g-4 " id="card">
                      @foreach($postlist as $list)
                      
                        <div class="col mb-3 " id="{{$list->id}}">
                            <div class="card h-100 rounded-3 shadow-sm custom-card"> 
                                <div class="card-body d-flex flex-column"> 
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{$list->user->profile}}" alt="profile" class="rounded-circle img-thumbnail @if($list->status == 1) custom-img-thumbnail @endif" style="width:60px; height: 60px;">
                                        <div class="ms-3">
                                            @if($list->user->type == 1)
                                                <p class="mb-0">User</p>
                                            @else
                                                <p class="mb-0">Admin</p>
                                            @endif
                                            <p>{{$list->created_at->format('Y-m-d')}}</p>
                                        </div>
                                        @if(auth()->user()->type == 1)
                                          @if(auth()->user()->id == $list->created_user_id)
                                            <div class="dropdown custom-dropdown ms-auto">
                                              <button class="btn btn-link p-0 text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa fa-ellipsis-h" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="edit and delete"></i>
                                              </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('post.edit', $list->id) }}"><i class="fa fa-edit me-2"></i>Edit</a></li>
                                                    <li><button class="dropdown-item delete_card" href="#"><i class="fa fa-trash me-2"></i>Delete</button></li>
                                                </ul>
                                            </div>
                                          @endif
                                        @else
                                            <div class="dropdown custom-dropdown ms-auto">
                                              <button class="btn btn-link p-0 text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa fa-ellipsis-h" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="edit and delete"></i>
                                              </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('post.edit', $list->id) }}"><i class="fa fa-edit me-2"></i>Edit</a></li>
                                                    <li><button class="dropdown-item delete_card" href="#"><i class="fa fa-trash me-2"></i>Delete</button></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <h5 class="card-title">{{ $list->title }}</h5>
                                    <p class="card-text">{{ $list->description }}</p>
                                </div>
                                <div class="card-footer mt-auto d-flex justify-content-between align-items-center "> 
                                  <div class="text-start pt-3 d-flex" id="{{$list->id}}">
                                      <div>
                                        <p  id="likeButton" class="me-2 align-middle">
                                            @if ($list->likes->contains('user_id', auth()->id()))
                                                <i class="fa-solid fa-thumbs-up text-primary" ></i>
                                            @else
                                            <i class="fa-solid fa-thumbs-up"></i>
                                            @endif
                                        </p>
                                      </div>
                                      <div>
                                        <p class="likeCount" id="likeCount{{ $list->id }}">
                                                {{ $list->likes()->count() }} {{ Str::plural('like', $list->likes()->count()) }}
                                        </p>
                                      </div>
                                  </div>
                                  <div class="text-end">
                                    <button class=" post_detail_card view" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                     data-bs-title="view"><i class="fa fa-eye fa-lg"></i></button>
                                  </div>
                                </div>
                            </div>
                        </div>                    
                      @endforeach
                    </div>
                  </div>
                <!-- end post card-->
            @endif
                  <!--start pagination-->
                  <div class="row">
                    <div class="col">
                        <nav aria-label="Page navigation">
                            <ul class="pagination" id="paginationLinks">
                                {!! $postlist->appends(request()->except('page'))->links() !!}
                            </ul>
                        </nav>
                    </div>
                  </div>
                    <!--end pagination-->
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
                    <p><strong>Are you sure you want to delete this post?</strong></p>
                    <div class="row mb-3">
                      <div class="col-5"><strong>ID:</strong></div>
                      <div class="col-7"><span id="postid"></span></div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-5"><strong>Title:</strong></div>
                      <div class="col-7"><span id="posttitle"></span></div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-5"><strong>Description:</strong></div>
                      <div class="col-7"><span id="postdescription"></span></div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-5"><strong>Status:</strong></div>
                      <div class="col-7"><span id="poststatus"></span></div>
                    </div>
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
                      <div class="col-5"><span id="title" class="text-dark"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Status:</strong></div>
                      <div class="col-5"><span id="status"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Description:</strong></div>
                      <div class="col-5"><span id="des"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Created Date:</strong></div>
                      <div class="col-5"><span id="created_date"></span></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-5"><strong>Created User:</strong></div>
                      <div class="col-5"><span id="created_user"></span></div>
                    </div><div class="row mt-4">
                      <div class="col-5"><strong>Updated Date:</strong></div>
                      <div class="col-5"><span id="updated_date"></span></div>
                    </div><div class="row mt-4">
                      <div class="col-5"><strong>Updated User:</strong></div>
                      <div class="col-5"><span id="updated_user"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!--end post detail modal-->
    <img src="{{asset('uploads/page_top.png')}}" alt="pagetop" class="pagetop" id="scrolltop" onclick="scrollToTop()">
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function(){
      var form=$('#form');
      $('#uploadpost').on('click',function(){
        form.attr('action','{{url("/uploadpost")}}')
      });

      $('#createpost').on('click',function(){
        form.attr('action','{{url("/createpost")}}');
      });
      
      $('#downloadpost').on('click',function(){
        form.attr('action','{{url("/download_all")}}');
      });
      $('#search_post').on('click',function(){
        form.attr('action','{{url("/search_allpost_card")}}');
      })
    });

     //start post delete for card
    $(document).ready(function () {
        $(document).on('click','.delete_card',function(e){
        var parentDiv = $(this).closest('.col.mb-3');
        var id = parentDiv.attr('id');
            console.log(id);
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
                            $('#postModal').modal('hide');
                            iziToast.success({
                            title: '',
                            position: 'topRight',
                            class: 'iziToast-custom',
                            message: response.message,
                            timeout: 5000 // duration in milliseconds (adjust as needed)
                              });
                                setTimeout(function() {
                                    location.reload();
                                }, 5000);
                                
                          }
                      });
                    });
              }             
            }
           });
        });
    });
    //end post delete for card

    // start post deail modal box for card  
    $(document).ready(function(){
      console.log('hi')
      $(document).on('click','.post_detail_card',function(){
      
        var parentDiv = $(this).closest('.col.mb-3');
        var id = parentDiv.attr('id');
        console.log(id)
        $.ajax({
          method:`post`,
          url:`/postdetails/${id}`,
          dataType: 'json',
          success:function(response){
            console.log(response)
            var post=response.postdetail;
            $('#postdetailModal').modal('show')
            $('#title').text(post.title)
            $('#title').attr('style', 'color: blue;');
            $('#status').text(post.status)
            $('#des').text(post.description)

            var created_at=new Date(post.created_at);
            created_at.setMinutes(created_at.getMinutes() - created_at.getTimezoneOffset());
            var dateFormat=created_at.toISOString().split('T')[0];
            $('#created_date').text(dateFormat)

           $('#created_user').text(response.user[0])

           var updated_at=new Date(post.updated_at);
           updated_at.setMinutes(updated_at.getMinutes() - updated_at.getTimezoneOffset());
           var updated_date_format=updated_at.toISOString().split('T')[0];
            $('#updated_date').text(updated_date_format)
            $('#updated_user').text(response.user)
          }
        })
      })
    });
    // end post deail modal box for card 
    //start design view
    $(document).ready(function(){
      
      const toggleViewBtn = document.getElementById('ViewBtn');
      let currentRoute = "{{ Route::currentRouteName() }}";
      
      if (currentRoute === 'all_postlist' || currentRoute === 'search_allpost_table') {
          toggleViewBtn.textContent = "View Card";

      } else if (currentRoute === 'all_postlist_card' || currentRoute === 'search_allpost_card') {
          toggleViewBtn.textContent = "View Table ";
      }
     else if(currentRoute === 'search'){
      toggleViewBtn.textContent ='View Card ';
     }

    })
    //end design view
    //start page top
    function scrollToTop(){
      window.scrollTo({
        top:0,
        behavior:'smooth'
      })
    }
    window.onscroll = function(){ 
      if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
        document.getElementById('scrolltop').style.display = 'block'
      }
      else{
        document.getElementById('scrolltop').style.display = 'none'
      }
    }
    //enf page top
    //start like 
      $(document).ready(function() {
        $(document).on('click', '#likeButton', function(e) {
                  e.preventDefault();
                  let parent = $(this).closest('.text-start');
                  let id = parent.attr('id');
                  console.log(id);
                  $.ajax({
                      type: 'POST',
                      url: `/posts/${id}/toggle_like`,                      
                      success: function(response) {
                        location.reload();
                      }
                  });
              });
      });

    //end like

</script>

@endsection
@if(Session::has('success'))
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                    message: `{{ Session::get('success') }}`
                });
            });
         </script>  
@elseif(Session::has('postedites'))
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                    message: `{{ Session::get('postedites') }}`
                });
            });
         </script>     
@elseif(Session::has('error'))
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.danger({
                    title: '',
                    position: 'topRight',
                    class: 'iziToast-custom',
                    message: `{{ Session::get('error') }}`
                });
            });
         </script>  
@endif
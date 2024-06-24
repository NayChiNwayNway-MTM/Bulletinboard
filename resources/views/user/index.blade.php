@extends('layouts.nav')
@section('content')
<section>
<header><h2 class="px-5 py-2">User List</h2></header>
<div class="container">
      <form action="" method="post" class="mt-3">
          <div class="alert" role="alert" id="response">
          </div>
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
      <div class="row mt-5">
         <!-- Pagination Links -->
        <div class="">
            {!! $users->links() !!}
        </div>
        @foreach($users as $user)
        <div class="col-md-4 mb-4">
            <div class="card" id="{{$user->id}}">
                <div class="card-header">
                    <h5 class="card-title text-primary" id="user_detail">{{ $user->name }}</h5>
                   
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Email:</strong>{{ $user->email }}</p>
                    <p class="card-text"><strong>Created User:</strong> {{ $names[((($users->currentPage() * 5) - 5) + $loop->iteration) - 1] }}</p>
                    <p class="card-text"><strong>Type:</strong> {{ $user->type == 1 ? 'User' : 'Admin' }}</p>
                    <p class="card-text"><strong>Phone:</strong> {{ $user->phone }}</p>
                    <p class="card-text"><strong>Date of Birth:</strong> {{ $user->dob }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $user->address }}</p>
                    <p class="card-text"><strong>Created Date:</strong> {{ $user->created_at }}</p>
                    <p class="card-text"><strong>Updated Date:</strong> {{ $user->updated_at }}</p>
                </div>
                <div class="card-footer">
                    
                    <a href="#" class="btn btn-sm btn-danger userdelete" data-id="{{ $user->id }}"><i class="fa fa-trash"></i></a>
                   
                </div>
            </div>
        </div>
        @endforeach
    </div>
   
</div>   
  <!-- start delete modal-->
  <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">Delete Confirm</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this post?</p>
                    <p><strong>ID:</strong> <span id="userid"></span></p>
                    <p><strong>Name:</strong> <span id="username"></span></p>
                    <p><strong>Type:</strong> <span id="usertype"></span></p>
                    <p><strong>Email:</strong> <span id="useremail"></span></p>
                    <p><strong>Phone:</strong> <span id="userphone"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="userdob"></span></p>
                    <p><strong>Address:</strong> <span id="useraddress"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
  </div>
   <!--end delete modal-->
  <!--start detail modal-->
  <div class="modal fade" id="userdetailModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="userdetailModalLabel">User Detail</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-4"><img src="" alt="Profile" id="user_profile" style="width: 150px; height: 150px;"></div>
                      <div class="col-8">
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Name:</strong>
                          </div>
                          <div class="col-7"><span id="name"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Type:</strong> 
                          </div>
                          <div class="col-7"><span id="type"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Email:</strong> 
                          </div>
                          <div class="col-7"><span id="email"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Phone:</strong> 
                          </div>
                          <div class="col-7"><span id="phone"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Date Of Birth:</strong> 
                          </div>
                          <div class="col-7"><span id="dob"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Address:</strong> 
                          </div>
                          <div class="col-7"><span id="address"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Created Date:</strong> 
                          </div>
                          <div class="col-7"><span id="created_date"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Created User:</strong> 
                          </div>
                          <div class="col-7"><span id="created_user"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Updated Date:</strong> 
                          </div>
                          <div class="col-7"><span id="updated_date"></span></div>
                        </div>
                        <div class="row  mb-3">
                          <div class="col-5">
                            <strong>Updated User:</strong> 
                          </div>
                          <div class="col-7"><span id="updated_user"></span></div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                
                </div>
            </div>
        </div>
  </div>
    <!--end detail modal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // start delete user 
        $(document).ready(function(){
         
          $('.userdelete').on('click',function(e){
           
            let id=$(this).data('id');
            e.preventDefault();
            $.ajax({
              method:`post`,
              url:`user/userdelete/${id}`,
              success:function(response){
                var user=response.userinfo;
                if(response.success){
                  $('#postModal').modal('show');
                  $('#userid').text(user.id);
                  $('#username').text(user.name);
                  if(user.type==1){
                    $('#usertype').text("User");
                  }
                  else{
                    $('#usertype').text("Admin");
                  }
                  $('#useremail').text(user.email);
                  $('#userphone').text(user.phone);
                  $('#userdob').text(user.dob);
                  $('#useraddress').text(user.address);
                  $('#confirmDelete').on('click',function(){
                    $.ajax({
                      method:`post`,
                      url:`user/deleteduser/${id}`,
                      success:function(response){
                       console.log(response.success);
                       $('#response').text(response.success);
                       location.reload();
                      }
                     
                    });
                  });
                }
              }
            })            
          });
        });
        //end delete user
        //start user details
          $(document).ready(function(){
            $(document).on('click','#user_detail',function(){
              var tag=this.parentElement.parentElement;
              var id=tag.getAttribute('id');
              console.log(id);
              $.ajax({
                method:`post`,
                url:`/user/detail/${id}`,
                success:function(response){
                  console.log(response)
                  var user=response.detail;
                  console.log(user.name)
                  if(response.detail){
                    $('#user_profile').attr('src', user.profile);
                    $('#userdetailModal').modal('show');
                    $('#name').text(user.name);
                    if(user.type==1){
                      $('#type').text("User");
                    }
                    else{
                      $('#type').text("Admin");
                    }
                    $('#email').text(user.email);
                    $('#phone').text(user.phone);
                    $('#dob').text(user.dob);
                    $('#address').text(user.address);
                    $('#created_date').text(user.created_at);
                    $('#updated_date').text(user.updated_at);
                    $('#updated_user').text(response.created_user);
                    $('#created_user').text(response.created_user);
                  }
               
                }
              })
            })
          });
        //end user details
    </script>
</section>
@endsection
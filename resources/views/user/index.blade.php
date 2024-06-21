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
        <?php $index=0 ?>
            @foreach($users as $user)
            <tr id='{{$user->id}}'>
              <td>{{(($users->currentPage()*5)-5)+$loop->iteration}}</td>
              <td><a href="#" class=" link-underline link-underline-opacity-0">{{$user->name}}</a></td>
              <td>{{$user->email}}</td>
              <td>{{$names[((($users->currentPage()*5)-5)+$loop->iteration)-1]}}</td>
              @if($user->type == 1)
                <td>User</td>              
              @else
                <td>Admin</td>             
              @endif           
              <td>{{$user->phone}}</td>
              <td>{{$user->dob}}</td>
              <td>{{$user->address}}</td>
              <td>{{$user->created_at}}</td>
              <td>{{$user->updated_at}}</td>
              <td><a href="" class="btn btn-danger userdelete">Delete</a></td>
            </tr>
            <?php $index++?>
            @endforeach
        </tbody>
      </table> 
      {!!$users->links()!!}
</div>   
  <!--start modal-->
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
    <!--end modal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
         
          $('.userdelete').on('click',function(e){
            let tr=this.parentElement.parentElement;
            let id=tr.getAttribute('id');
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
    </script>
</section>
@endsection
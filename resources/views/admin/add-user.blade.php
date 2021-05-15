
<!DOCTYPE html>
<html>
@include('admin.theme.head',['title' => 'Update User'])
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  @include('admin.theme.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add new User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Admin Add New User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Missing Fields!</h4>
            {!! implode('', $errors->all('. :message <br>')) !!}
        </div>
    @endif
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>

            <form method="post" action="/admin/create-user" class="card-body" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="inputName">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter Username" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputName">First name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputName">Last name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="inputStatus">User type</label>
                        <select class="form-control custom-select" name="user_type">
                            <option selected disabled>Select one</option>
                            <option value="0" >Root User</option>
                            <option value="1" >Normal User</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatus">Status</label>
                        <select class="form-control custom-select" name="status">
                            <option selected disabled>Select one</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatus">Role</label>
                        <select class="form-control custom-select" name="role">
                            <option selected disabled>Select one</option>
                            <option value="0">Default</option>
                            @foreach ($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputProjectLeader">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputProjectLeader">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" value="">
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
                    <div class="col-12">
                        <input type="submit" value="Create New User" class="btn btn-primary float-right">
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('admin.theme.footer')
</body>
</html>

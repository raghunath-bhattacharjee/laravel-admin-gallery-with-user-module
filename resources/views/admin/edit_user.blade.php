
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
            <h1>Edit User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Admin Edit User</li>
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
              <h3 class="card-title">Mode: Edit / User: {{$user->first_name}} / Published at: {{Carbon\Carbon::parse($user->created_at)->tz('Asia/kolkata')->format('d M, Y H:s A')}}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>

            <form method="post" action="/admin/update-user/{{$user->id}}" class="card-body" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="inputName">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter Username" value="{{$user->username}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputName">First name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="{{$user->first_name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputName">Last name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="{{$user->last_name}}">
                    </div>

                     <div class="form-group col-md-4">
                        <label for="inputProjectLeader">User Email</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="inputStatus">User type</label>
                        <select class="form-control custom-select" name="user_type">
                            <option selected disabled>Select one</option>
                            <option value="0" {{$user->user_type == 0 ? 'selected' : ''}}>Root User</option>
                            <option value="1" {{$user->user_type == 1 ? 'selected' : ''}}>Normal User</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatus">Status</label>
                        <select class="form-control custom-select" name="status">
                            <option selected disabled>Select one</option>
                            <option value="1" {{$user->status ? 'selected' : ''}}>Active</option>
                            <option value="0" {{!$user->status ? 'selected' : ''}}>In-Active</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatus">Role</label>
                        <select class="form-control custom-select" name="role">
                            <option selected disabled>Select one</option>
                            <option value="0" {{$user->role == 0 ? 'selected' : ''}}>Default</option>
                            @foreach ($permissions as $permission)
                                <option value="{{$permission->id}}" {{$user->role == $permission->id  ? 'selected' : ''}}>{{$permission->role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
                    <div class="col-12">
                        <input type="submit" value="Update User" class="btn btn-primary float-right">
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>

@include('admin.theme.footer')
</body>
</html>

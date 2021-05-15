
<!DOCTYPE html>
<html>
@include('admin.theme.head',['title' => 'Admin Profile'])
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('admin.theme.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Admin Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
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
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! implode('', $errors->all('. :message <br>')) !!}
            </div>
        @endif
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- Admin form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Admin Info</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/update_profile">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">UserName</label>
                            <input type="text" class="form-control" name="username" value="{{Auth::user()->username}}" disabled>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="name" class="form-control" name="first_name" value="{{Auth::user()->first_name}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="name" class="form-control" name="last_name" value="{{Auth::user()->last_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Enter New Password</label>
                        <input type="text" class="form-control"  name="password" value="" placeholder="Change password">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="example">Permissions</label>
                            <p>
                                {!! Auth::user()->getPermissions() !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" style="float:right">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@include('admin.theme.footer')
</div>
</body>
</html>

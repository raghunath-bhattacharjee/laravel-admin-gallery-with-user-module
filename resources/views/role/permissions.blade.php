
<!DOCTYPE html>
<html>
@include('admin.theme.head',['title' => 'Roles & Permissions'])
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('admin.theme.sidebar')
    <div class="content-wrapper">
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles & Permissions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Admin Roles & Permissions</li>
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

                    <form method="post" action="/admin/create-role-permission" class="card-body" >
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="inputName">Role Name</label>
                                <input type="text" class="form-control" name="role" placeholder="Enter role" value="">
                            </div>
                            <div class="col-md-8">
                                <label for="inputStatus">Permissions</label>
                                <select class="form-control custom-select" name="permissions[]" multiple>
                                    <option selected disabled>Select one</option>
                                    <option value="0">Default</option>
                                    <option value="1">View</option>
                                    <option value="2">Edit</option>
                                    <option value="3">Create</option>
                                    <option value="4">Delete</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px">
                            <br>
                            <div class="col-12">
                                <input type="submit" value="Create New Role" class="btn btn-primary float-right">
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">All Roles & Permissions</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $index => $permission)
                                <tr>
                                    <td>{{$index+1}}.</td>
                                    <td>{{$permission->role}}</td>
                                    <td>{!! $permission->getPermissions() !!}</td>
                                    <td style="text-align:right">
                                        <button class="btn btn-danger" onclick="deleteRole({{$permission->id}})" title="Delete Role">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.theme.footer')
</body>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  function deleteRole(id){
    var status = confirm('Are you sure you want to delete this role.');
    if(status){
        location.replace('/admin/delete-role/'+id);
    }
  }
</script>
</html>

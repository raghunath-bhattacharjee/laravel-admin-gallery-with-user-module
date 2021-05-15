
<!DOCTYPE html>
<html>
@include('admin.theme.head',['title' => 'Gallery'])
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('admin.theme.sidebar')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Admin Gallery</li>
                    </ol>
                </div>
                </div>
            </div>
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
                    <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Photo Gallery</h3><br>
                    </div>
                    <span class="alert" style="background: #c0cfdc;margin: 0 10px">
                       <i class="fa fa-info-circle"> </i> Click on image and see full image.
                    </span>
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Gallery</th>
                                    <th>Photos</th>
                                    <th>Creation Time</th>
                                    <th style="text-align:right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galleries as $index => $gallery)
                                    <tr>
                                        <td>{{$index +1 }}</td>
                                        <td>
                                            <a href="/admin/edit-gallery/{{$gallery->id}}" class="text-muted" title="Edit Gallery">
                                            {{$gallery->gallery}}
                                            </a>
                                        </td>
                                        <td>
                                            @foreach ($gallery->image_path as $src)
                                                <a href="/gallery/{{$src}}" target="_blank">
                                                    <img src="/gallery/{{$src}}" style="height:100px"/>
                                                </a>
                                            @endforeach
                                        </td>
                                        <td> {{Carbon\Carbon::parse($gallery->created_at)->tz('Asia/kolkata')->format('d M, y h:i a')}} </td>

                                        <td style="text-align:right">
                                            @if (Auth::user()->isSuperUser() || App\Gallery::canDelete(Auth::user()->role))
                                                <button class="btn btn-danger" onclick="deleteGallery({{$gallery->id}})" title="Delete Gallery">
                                                        <i class="fas fa-trash"></i>
                                                </button>
                                            @endif

                                            @if (Auth::user()->isSuperUser() || App\Gallery::canEdit(Auth::user()->role))
                                                <a href="/admin/edit-gallery/{{$gallery->id}}" class="text-muted" title="Edit Gallery">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                </a>
                                            @endif
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
  function deleteGallery(id){
    var status = confirm('Are you sure you want to delete this gallery.');
    if(status){
        location.replace('/admin/delete-gallery/'+id);
    }
}
</script>
</html>

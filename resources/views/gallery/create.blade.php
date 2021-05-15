
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <form method="post" action="{{url('/admin/create-gallery')}}" class="card-body" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputName">Gallery Name</label>
                                    <input type="text" class="form-control" name="gallery_name" placeholder="Enter gallery name" value="">
                                </div>
                                <div class="col-md-8">
                                    <label for="inputStatus">Upload Image</label>
                                    <input type="file" class="form-control" name="gallery_images[]" multiple>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom:20px">
                                <br>
                                <div class="col-12">
                                    <input type="submit" value="Create Gallery" class="btn btn-primary float-right">
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

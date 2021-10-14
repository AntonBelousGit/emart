@extends('backend.layouts.main')

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                    class="fa fa-arrow-left"></i></a>Banners</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Banners</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 text-right  btn-align-midl">
                        <div class="inlineblock text-center m-r-15 m-l-15  btn-align-midl">
                               <a href="{{route('banner.create')}}" class="btn btn-round btn-primary"><i class="icon-plus"></i> Create Banner</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-lg-12">

                    <div class="card">
                        <div class="header">
                            <h2>Table Tools<small>Basic example without any additional modification classes</small></h2>
                            <span>Total count: {{\App\Models\Banner::count()}}</span>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($banners as $banner)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$banner->title}}</td>
                                            <td>{!! html_entity_decode($banner->description) !!}</td>
                                            <td><img src="{{$banner->photo}}" alt="banner image"
                                                     class="banner-table-image"></td>
                                            <td>
                                                @if ($banner->condition === 'banner')
                                                    <span class="badge badge-success">{{$banner->condition}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{$banner->condition}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" data-toggle="toggle" name="toogle"
                                                       value="{{$banner->id}}" data-on="active" data-off="inactive"
                                                       {{ $banner->status === 'active' ? 'checked':'' }}
                                                       data-size="small" data-onstyle="success" data-offstyle="danger"
                                                       class="banner-switcher" onchange="bannerStatus(this)"
                                                >
                                            </td>
                                            <td>
                                                <a href="{{route('banner.edit',$banner->id)}}" data-toggle="tooltip"
                                                   class="btn btn-sm btn-outline-primary" title="edit"
                                                   data-placement="bottom">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{route('banner.destroy',$banner->id)}}" data-toggle="tooltip"
                                                   class="btn btn-sm btn-outline-danger" title="delete"
                                                   data-placement="bottom">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="{{asset('backend/assets/bundles/libscripts.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/bundles/vendorscripts.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/vendor/sweetalert/sweetalert.min.js')}}"></script> <!-- SweetAlert Plugin Js -->
    <script src="{{asset('backend/assets/bundles/mainscripts.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/pages/tables/jquery-datatable.js')}}"></script>
    <script>
        function bannerStatus(el) {
            var mode = $(el).prop('checked');
            var id = $(el).val();

            $.ajax({
                url: "{{route('banner.status')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    mode: mode,
                    id: id,
                },
                success: function (response) {
                    if (response.status) {
                        alert(response.msg);
                    } else {
                        alert('Please try again!');
                    }
                }
            })
        }
    </script>

@endsection

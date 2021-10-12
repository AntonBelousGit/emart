@extends('backend.layouts.main')

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Jquery Datatable</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Table</li>
                            <li class="breadcrumb-item active">Jquery Datatable</li>
                        </ul>
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <div class="inlineblock text-center m-r-15 m-l-15 hidden-sm">
                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1" data-line-Color="#00c5dc"
                                 data-fill-Color="transparent">3,5,1,6,5,4,8,3</div>
                            <span>Visitors</span>
                        </div>
                        <div class="inlineblock text-center m-r-15 m-l-15 hidden-sm">
                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1" data-line-Color="#f4516c"
                                 data-fill-Color="transparent">4,6,3,2,5,6,5,4</div>
                            <span>Visits</span>
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
                            <h2>Table Tools<small>Basic example without any additional modification classes</small> </h2>
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
                                                <td>{{$banner->description}}</td>
                                                <td><img src="{{$banner->photo}}" alt="banner image" class="banner-table-image"></td>
                                                <td>
                                                    @if ($banner->condition === 'banner')
                                                        <span class="badge badge-success">{{$banner->condition}}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{$banner->condition}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="checkbox" checked data-toggle="toggle" data-on="active" data-off="inactive" data-size="small" data-onstyle="success" data-offstyle="danger">
                                                </td>
                                                <td>
                                                    <a href="{{route('banner.edit',$banner)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary" title="edit" data-placement="bottom">
                                                        <i class="fa fa-edit"></i>
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
@endsection

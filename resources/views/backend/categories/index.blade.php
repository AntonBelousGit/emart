@extends('backend.layouts.main')

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                    class="fa fa-arrow-left"></i></a>Categories</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 text-right  btn-align-midl">
                        <div class="inlineblock text-center m-r-15 m-l-15  btn-align-midl">
                            <a href="{{route('category.create')}}" class="btn btn-round btn-primary"><i class="icon-plus"></i> Create Category</a>
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
                            <span>Total count: {{\App\Models\Category::count()}}</span>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Photo</th>
                                        <th>Is parent</th>
                                        <th>Parents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Photo</th>
                                        <th>Is parent</th>
                                        <th>Parents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($categories as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->title}}</td>
                                            <td><img src="{{$item->photo}}" alt="banner image"
                                                     class="banner-table-image"></td>
                                            <td>{{$item->is_parent === 1 ? 'Parent': 'Child'}}</td>
                                            <td>{{$item->parent_id}}</td>
                                            <td>
                                                <input type="checkbox" data-toggle="toggle" name="toogle"
                                                       value="{{$item->id}}" data-on="active" data-off="inactive"
                                                       {{ $item->status === 'active' ? 'checked':'' }}
                                                       data-size="small" data-onstyle="success" data-offstyle="danger"
                                                       class="banner-switcher" onchange="categoryStatus(this)"
                                                >
                                            </td>
                                            <td>
                                                <a href="{{route('category.edit',$item->id)}}" data-toggle="tooltip"
                                                   class="btn btn-sm btn-outline-primary float-left" title="edit"
                                                   data-placement="bottom">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form class="float-left ml-1" action="{{route('category.destroy',$item->id)}}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <a  data-toggle="tooltip" title="delete" data-id="{{$item->id}}" class="dltBtn btn btn-sm btn-outline-danger" data-placement="bottom" data-original-title="delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </form>
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
    <script src="{{asset('backend/vendor/sweetalert/sweetalert.min.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form=$(this).closest('form');
            var dataID=$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Category!!!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your Category has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Category is safe!");
                    }
                });

        });

        function categoryStatus(el) {
            var mode = $(el).prop('checked');
            var id = $(el).val();

            $.ajax({
                url: "{{route('category.status')}}",
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

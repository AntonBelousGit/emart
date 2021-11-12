@extends('backend.layouts.main')

@section('style')
    <link rel="stylesheet" href="{{asset('backend/vendor/sweetalert/sweetalert.css')}}">
@endsection

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                    class="fa fa-arrow-left"></i></a>Users</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 text-right  btn-align-midl">
                        <div class="inlineblock text-center m-r-15 m-l-15  btn-align-midl">
                               <a href="{{route('user.create')}}" class="btn btn-round btn-primary"><i class="icon-plus"></i> Create User</a>
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
                            <span>Total Users: {{$user_count}}</span>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Username</th>
                                        <th>Photo</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>№</th>
                                        <th>Username</th>
                                        <th>Photo</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($users as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->username}}</td>
                                            <td><img src="{{$item->photo}}" alt="banner image"
                                                     class="banner-table-image"></td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->role}}</td>
                                            <td>
                                                <input type="checkbox" data-toggle="toggle" name="toogle"
                                                       value="{{$item->id}}" data-on="active" data-off="inactive"
                                                       {{ $item->status === 'active' ? 'checked':'' }}
                                                       data-size="small" data-onstyle="success" data-offstyle="danger"
                                                       class="banner-switcher" onchange="userStatus(this)"
                                                >
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-sm btn-outline-secondary float-left" title="view"
                                                   data-placement="bottom" data-toggle="modal"
                                                   data-target="#productID" data-id="{{$item->id}}"
                                                   onclick="userView(this)">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{route('user.edit',$item->id)}}" data-toggle="tooltip"
                                                   class="btn btn-sm btn-outline-primary float-left" title="edit"
                                                   data-placement="bottom">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form class="float-left ml-1" action="{{route('user.destroy',$item->id)}}" method="post">
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
    <!-- Modal -->
    <div class="modal fade" id="productID" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
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
                text: "Once deleted, you will not be able to recover this User",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your User has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your User is safe!");
                    }
                });

        });

        function userStatus(el) {
            var mode = $(el).prop('checked');
            var id = $(el).val();

            $.ajax({
                url: "{{route('user.status')}}",
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
        function userView(el) {
            const id = $(el).data('id');
            console.log(id);
            $.ajax({
                url: "{{route('user.view')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                },
                success: function (response) {
                    $(".modal-body").html(response.html);
                }
            })
        }
    </script>

@endsection

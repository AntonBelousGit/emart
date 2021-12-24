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
                                    class="fa fa-arrow-left"></i></a>Products</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Products attribute</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('backend.layouts.notification')
                </div>
                <div class="col-lg-12">

                    <div class="card">
                        <div class="header">
                            <h2><strong>{{ucfirst($product->title)}}</strong></h2>
                            <div class="row">
                                <div class="col-md-12"></div>
                            </div>
                        </div>
                        <div class="body">
                            <form action="{{route('product.attribute',$product->id)}}" method="post">
                                @csrf
                                <div id="product-attribute" class="content"
                                     data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" id="btnAdd-1" class="btn btn-primary mb-1"><i
                                                    class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-2">
                                            <label for="">Size</label>
                                            <input class="form-control" placeholder="eg. S" name="size[]" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Original Price</label>
                                            <input class="form-control" placeholder="eg. 1500" step="any"
                                                   name="original_price[]"
                                                   type="number">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Offer Price</label>
                                            <input class="form-control" placeholder="eg. 1200" step="any"
                                                   name="offer_price[]"
                                                   type="number">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Stock</label>
                                            <input class="form-control" placeholder="eg. 4" name="stock[]"
                                                   type="number">
                                        </div>
                                        <div class="col-md-2" style="margin: auto 0 0;">
                                            <button type="button" class="btn btn-danger btnRemove">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Submit</button>
                            </form>
                            <div class="row mt-4">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Original Price</th>
                                            <th>Offer</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Size</th>
                                            <th>Original Price</th>
                                            <th>Offer</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @if(count($product_attribute)>0)

                                                @foreach($product_attribute as $item)
                                                    <tr>
                                                        <td>{{$item->size}}</td>
                                                        <td>$ {{number_format($item->original_price,2)}}</td>
                                                        <td>$ {{number_format($item->offer_price,2) }}</td>
                                                        <td>{{$item->stock}}</td>
                                                        <td>
                                                            <form class="float-left ml-1"
                                                                  action="{{route('product.attribute.destroy',$item->id)}}" method="post">
                                                                @csrf
                                                                @method("DELETE")
                                                                <a data-toggle="tooltip" title="delete" data-id="{{$item->id}}"
                                                                   class="dltBtn btn btn-sm btn-outline-danger"
                                                                   data-placement="bottom" data-original-title="delete">
                                                                    <i class="fa fa-remove"></i>
                                                                </a>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('backend/assets/js/jquery.multifield.min.js')}}"></script>
    <script src="{{asset('backend/vendor/sweetalert/sweetalert.min.js')}}"></script> <!-- SweetAlert Plugin Js -->
    <script>
        $('#product-attribute').multifield();
    </script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Product",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your Product has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Product is safe!");
                    }
                });

        });

        function productView(el) {
            const id = $(el).data('id');
            $.ajax({
                url: "{{route('product.view')}}",
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

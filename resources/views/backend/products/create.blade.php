@extends('backend.layouts.main')

@section('style')
    <link rel="stylesheet" href="{{asset('backend/vendor/summernote/dist/summernote.css')}}">
@endsection

@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                    class="fa fa-arrow-left"></i></a>Add Products</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i
                                        class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Products</li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <form action="{{route('product.store')}}" method="POST">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Title" name="title"
                                                   value="{{old('title')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Summary <span class="text-danger">*</span></label>
                                            <textarea id="summary" type="text" class="form-control"
                                                      placeholder="Some text..." name="summary">
                {{old('summary')}}
                </textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea id="summernote"
                                                      name="description">{{old('description')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Stock" name="stock"
                                                   value="{{old('stock')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Price <span class="text-danger">*</span></label>
                                            <input type="number" step="any" class="form-control" placeholder="Price"
                                                   name="price"
                                                   value="{{old('price')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Discount</label>
                                            <input type="number" step="any" class="form-control" placeholder="Discount"
                                                   name="discount"
                                                   value="{{old('discount')}}">
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-lg-12 col-md-12">--}}
                                    {{--                                        <div class="form-group">--}}
                                    {{--                                            <label for="">URL </label>--}}
                                    {{--                                            <input type="text" class="form-control" placeholder="URL" name="slug" value="{{old('slug')}}">--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Photo</label>
                                            <div class="input-group">
                       <span class="input-group-btn">
                         <a id="lfm" data-input="thumbnail" data-preview="holder"
                            class="btn btn-primary">
                           <i class="fa fa-picture-o"></i> Choose
                         </a>
                       </span>
                                                <input id="thumbnail" class="form-control" type="text" name="photo">
                                            </div>
                                            <div id="holder" style="margin-top:15px;max-height:100px;">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Brands <span class="text-danger">*</span></label>
                                        <select name="brand_id" class="form-control show-tick" required>
                                            <option value="">-- Brands --</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Category <span class="text-danger">*</span></label>
                                        <select id="cat_id" name="cat_id" class="form-control show-tick" required>
                                            <option value="">-- Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 d-none" id="child_cat_div">
                                        <label for="status">Child Category</label>
                                        <select id="child_cat_id" name="child_cat_id" class="form-control show-tick"
                                                >
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Size <span class="text-danger">*</span></label>
                                        <select name="size" class="form-control show-tick" required>
                                            <option value="">-- Size --</option>
                                            <option value="S" {{old('size')=== 'S' ? 'selected': ''}}>
                                                S
                                            </option>
                                            <option value="M" {{old('size')=== 'M' ? 'selected': ''}}>
                                                M
                                            </option>
                                            <option value="L" {{old('size')=== 'L' ? 'selected': ''}}>
                                                L
                                            </option>
                                            <option value="XL" {{old('size')=== 'XL' ? 'selected': ''}}>
                                                XL
                                            </option>
                                            <option value="XXL" {{old('size')=== 'XXL' ? 'selected': ''}}>
                                                XXL
                                            </option>
                                            <option value="XXXL" {{old('size')=== 'XXXL' ? 'selected': ''}}>
                                                XXXL
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Condition <span class="text-danger">*</span></label>
                                        <select name="condition" class="form-control show-tick" required>
                                            <option value="new" {{old('condition')=== 'new' ? 'selected': ''}}>
                                                New
                                            </option>
                                            <option value="popular" {{old('condition')=== 'popular' ? 'selected': ''}}>
                                                Popular
                                            </option>
                                            <option value="winter" {{old('condition')=== 'winter' ? 'selected': ''}}>
                                                Winter
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Vendors <span class="text-danger">*</span></label>
                                        <select name="vendor_id" class="form-control show-tick" required>
                                            <option value="">-- Vendors --</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{$vendor->id}}">{{$vendor->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control show-tick" required>
                                            <option value="active" {{old('status')=== 'active' ? 'selected': ''}}>
                                                Active
                                            </option>
                                            <option value="inactive" {{old('status')=== 'inactive' ? 'selected': ''}}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-t-15">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('backend/vendor/summernote/dist/summernote.js')}}"></script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $('#lfm').filemanager('image');
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#summary').summernote();
        });
    </script>
    <script>
        $('#cat_id').change(function () {
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        cat_id: cat_id,
                    },
                    success: function (response) {
                        let html_option = "<option value=''>--Child Category</option>"
                        if (response.status) {
                            $('#child_cat_div').removeClass('d-none');
                            $.each(response.data, function (id, title) {
                                html_option += "<option value='" + id + "'>" + title + "</ooption>"
                            })
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                })
            }
        })
    </script>
@endsection

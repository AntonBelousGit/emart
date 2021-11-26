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
                                    class="fa fa-arrow-left"></i></a>Add Coupons</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i
                                        class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Coupons</li>
                            <li class="breadcrumb-item active">Add Coupon</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <form action="{{route('coupon.store')}}" method="POST">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Coupon Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required placeholder="eg. HAPPY"
                                                   name="code"
                                                   value="{{old('code')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="status">Coupon Type <span class="text-danger">*</span></label>
                                            <select name="type" class="form-control show-tick" required>
                                                <option value="fixed" {{old('type')=== 'fixed' ? 'selected': ''}}>
                                                    Fixed
                                                </option>
                                                <option value="percent" {{old('type')=== 'percent' ? 'selected': ''}}>
                                                    Percent
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">

                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control show-tick" required>
                                                <option value="active" {{old('status')=== 'active' ? 'selected': ''}}>
                                                    Active
                                                </option>
                                                <option
                                                    value="inactive" {{old('status')=== 'inactive' ? 'selected': ''}}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">

                                            <div class="form-group">
                                                <label for="">Coupon Value <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required placeholder="eg. 10%"
                                                       name="value"
                                                       value="{{old('value')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-t-15">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('coupon.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
@endsection

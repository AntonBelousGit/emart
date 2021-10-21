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
                                    class="fa fa-arrow-left"></i></a>Add Brands</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i
                                        class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Brands</li>
                            <li class="breadcrumb-item active">Add Brands</li>
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
                            <form action="{{route('brand.store')}}" method="POST">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required placeholder="Title" name="title"
                                                   value="{{old('name')}}">
                                        </div>
                                    </div>

                                    {{--  <div class="col-lg-12 col-md-12">--}}
                                    {{--  <div class="form-group">--}}
                                    {{-- <label for="">URL </label>--}}
                                    {{--  <input type="text" class="form-control" placeholder="URL" name="slug" value="{{old('slug')}}">--}}
                                    {{-- </div>--}}
                                    {{-- </div>--}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Photo <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                   <span class="input-group-btn">
                                                     <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                        class="btn btn-primary">
                                                       <i class="fa fa-picture-o"></i> Choose
                                                     </a>
                                                   </span>
                                                <input id="thumbnail" class="form-control" type="text" required name="photo">
                                            </div>
                                            <div id="holder" style="margin-top:15px;max-height:100px;">

                                            </div>

                                        </div>
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
@endsection

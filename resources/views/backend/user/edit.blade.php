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
                                    class="fa fa-arrow-left"></i></a>Add Users</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i
                                        class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                            </ul>1
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <form action="{{route('user.update',$user->id)}}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Full name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Full name" name="full_name"
                                                   value="{{$user->full_name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Username" name="username"
                                                   value="{{$user->username}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Email address" name="email"
                                                   value="{{$user->email}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input type="text" class="form-control" placeholder="Phone number" name="phone"
                                                   value="{{$user->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control" placeholder="Address" name="address"
                                                   value="{{$user->address}}">
                                        </div>
                                    </div>
{{--                                    <div class="col-lg-12 col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="">Password <span class="text-danger">*</span></label>--}}
{{--                                            <input type="password" class="form-control" placeholder="Password" name="password" required>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
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
                                                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$user->photo}}">
                                            </div>
                                            <div id="holder" style="margin-top:15px;max-height:100px;">

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Role <span class="text-danger">*</span></label>
                                        <select name="role" class="form-control show-tick" required>
                                            <option value="">-- Role --</option>
                                            <option value="admin" {{$user->role === 'admin' ? 'selected': ''}}>
                                                Admin
                                            </option>
                                            <option value="vendor" {{$user->role === 'vendor' ? 'selected': ''}}>
                                                Vendor
                                            </option>
                                            <option value="customer" {{$user->role === 'customer' ? 'selected': ''}}>
                                                Customer
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control show-tick" required>
                                            <option value="active" {{$user->status === 'active' ? 'selected': ''}}>
                                                Active
                                            </option>
                                            <option value="inactive" {{$user->status === 'inactive' ? 'selected': ''}}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-t-15">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Update</button>
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

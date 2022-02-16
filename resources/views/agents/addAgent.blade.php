@extends('master')

@section('header')
@include('header')
@endsection

@section('body')
{{-- Admin Add Agent Section --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', \App\Models\AdminUser::class))
<div class="app-content main-content">
    <div class="side-app">
        <form action="{{ route('admin.agents.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card" id="left-card">
                        <div class="card-header">
                            <h3 class="card-title">Add Agent</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" autocomplete="name" autofocus
                                        class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Mobile <span class="text-red">*</span></label>
                                        <input type="text" name="mobile" placeholder="017xxxxxxxx" value="{{ old('mobile') }}" autocomplete="mobile"
                                        class="form-control @error('mobile') is-invalid @enderror" required>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email <span class="text-red">*</span></label>
                                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Password <span class="text-red">*</span></label>
                                        <input type="password" name="password" placeholder="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NID Number <span class="text-red">*</span></label>
                                        <input type="text" placeholder="NID Number" name="nid" value="{{ old('nid') }}" autocomplete="nid"
                                        class="form-control @error('nid') is-invalid @enderror" required>
                                        @error('nid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Address <span class="text-red">*</span></label>
                                        <input type="text" placeholder="Home Address" name="address" value="{{ old('address') }}" autocomplete="address"
                                        class="form-control @error('address') is-invalid @enderror" required>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" autocomplete="city"
                                        class="form-control @error('city') is-invalid @enderror" required>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Postal Code</label>
                                        <input type="number" placeholder="ZIP Code" name="postal_code" value="{{ old('postal_code') }}" autocomplete="zip_code"
                                        class="form-control @error('postal_code') is-invalid @enderror">
                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex w-100">
                                    <div class="btn-list mx-auto">
                                        <button class="btn btn-pill btn-success px-5">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card" id="right-card">
                        <div class="card-header">
                            <h3 class="card-title">File Upload</h3>
                        </div>

                        <div class=" card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label text-center">Profile Picture <span class="text-red">*</span></label>
                                    <input type="file" class="dropify" data-height="292" name="profile_pic"
                                    class="dropify">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label text-center">NID <span class="text-red">*</span></label>
                                    <input type="file" class="dropify" data-height="292" name="nid_pic"
                                    class="dropify" required/>                            
                                </div>
                            </div>
                            <div class="row" style="height=60px !important">
                                <div class="col-lg-6 col-sm-12" style="height=60px !important">
                                    @error('profile_pic')
                                    <label class="text-danger h-100" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    @error('nid_pic')
                                    <label class="text-danger h-100" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </form>
    </div>
</div>
@endif
{{-- ! Admin Add Agent Section --}}

@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function(){
            adjustHeight()

            function adjustHeight() {
                var leftHeight = $('#left-card').height()
                var rightHeight = $('#right-card').height()

                if(leftHeight > rightHeight)
                    $('#right-card').height(leftHeight)
                if(leftHeight < rightHeight)
                    $('#left-card').height(rightHeight)
            }
        });
    </script>
@endsection
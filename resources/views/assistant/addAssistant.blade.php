@extends('master')

@section('header')
@include('header')
@endsection

@section('body')
<!-- for Partner -->
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class)
|| Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <form action="{{ route('admin.assistants.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card" id="left-card">
                            <div class="card-header">
                                <h3 class="card-title">Add Assistant</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- @if(Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Select Partner <span class="text-red">*</span></label>
                                            <select class="form-control custom-select select2" name="partner_select" required>
                                                <option value="">Select Partner</option> 
                                                @foreach ($partners as $partner)
                                                    <option value="{{ $partner->id }}">{{ $partner->name . '(' .$partner->system_id . ')' }}</option>    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif --}}

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Name <span class="text-red">*</span></label>
                                            <input type="text" name="name" placeholder="Name" autofocus value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" autocomplete="name" required>
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
                                            <input type="text" name="mobile" placeholder="017xxxxxxxx" value="{{ old('mobile') }}"
                                            class="form-control @error('mobile') is-invalid @enderror" autocomplete="mobile" required>
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NID Number <span class="text-red">*</span></label>
                                            <input type="text" placeholder="NID Number" name="nid" value="{{ old('nid') }}"
                                            class="form-control @error('nid') is-invalid @enderror" autocomplete="nid" required>
                                            @error('nid')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Driving License Number </label>
                                            <input type="text" placeholder="Driving License Number" name="driving_license" value="{{ old('driving_license') }}"
                                            class="form-control @error('driving_license') is-invalid @enderror" autocomplete="driving_license">
                                            @error('driving_license')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Address <span class="text-red">*</span></label>
                                            <input type="text" placeholder="Home Address" name="address" value="{{ old('address') }}"
                                            class="form-control @error('address') is-invalid @enderror" autocomplete="address" required>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City <span class="text-red">*</span></label>
                                            <input type="text" placeholder="City" name="city" value="{{ old('city') }}"
                                            class="form-control @error('city') is-invalid @enderror" autocomplete="city" required>
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Postal Code </label>
                                            <input type="number" class="form-control" placeholder="ZIP Code" name="postal_code" value="{{ old('zip_code') }}"
                                            class="form-control @error('postal_code') is-invalid @enderror" autocomplete="postal_code">
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
                                        <label class="form-label text-center">Profile Picture</label>
                                        <input type="file" class="dropify" data-height="140" name="profile_pic" value="{{ old('profile_pic') }}" required/>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label text-center">NID</label>
                                        <input type="file" class="dropify" data-height="140" name="nid_pic" required/>
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

                                <div class="row hide Company">
                                    <div class="col-lg-12 col-sm-12">
                                        <label class="form-label text-center">Driving License</label>
                                        <input type="file" class="dropify" data-height="120" name="driving_license_pic"/>
                                    </div>
                                </div>
                                <div class="row" style="height=60px !important">
                                    <div class="col-lg-12 col-sm-12" style="height=60px !important">
                                        @error('driving_license_pic')
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
<!-- for Partner -->

@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function(){
            adjustHeight()
            function adjustHeight() {
                var leftHeight = $('#left-card').height()
                var rightHeight = $('#right-card').height()

                if(leftHeight < rightHeight)
                    $('#left-card').height(rightHeight)
                if(leftHeight > rightHeight)
                    $('#right-card').height(leftHeight)
            }
        });
    </script>
@endsection
@extends('master')

@section('header')
@include('header')
@endsection

@section('body')
{{-- Admin or Moderator --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', \App\Models\AdminUser::class)
|| Auth::guard('admin_user')->user()->can('haveModeratorAccess', \App\Models\AdminUser::class))
<div class="app-content main-content">
    <div class="side-app">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card" id="left-card">
                        <div class="card-header">
                            <h3 class="card-title">Add Partner</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Category <span class="text-red">*</span></label>
                                        <select class="form-control custom-select select2 category-select" name="category" value="{{ $partner->category }}" required>
                                            <option value="Individual">Individual</option>
                                            <option value="Company" @if($partner->category == 'Company') selected @endif>Company</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" placeholder="Name" autofocus value="{{ $partner->name }}"
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
                                        <input type="text" name="mobile" placeholder="017xxxxxxxx" value="{{ $partner->mobile }}"
                                        class="form-control @error('mobile') is-invalid @enderror" autocomplete="mobile" required>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 hide Company">
                                    <div class="form-group">
                                        <label class="form-label">Company Name <span class="text-red">*</span></label>
                                        <input type="text" placeholder="Company name" name="company" value="{{ $partner->company }}"
                                        class="form-control @error('company') is-invalid @enderror" autocomplete="company">
                                        @error('company')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 hide Company">
                                    <div class="form-group">
                                        <label class="form-label">Trade License <span class="text-red">*</span></label>
                                        <input type="text" placeholder="Trade License Number" name="trade_license" value="{{ $partner->trade_license }}"
                                        class="form-control @error('trade_license') is-invalid @enderror" autocomplete="trade_license">
                                        @error('company')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email <span class="text-red">*</span></label>
                                        <input type="email" name="email" placeholder="Email" value="{{ $partner->email }}"
                                        class="form-control @error('email') is-invalid @enderror" autocomplete="email" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" placeholder="only fill to change password"
                                        class="form-control @error('password') is-invalid @enderror" autocomplete="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">NID Number <span class="text-red">*</span></label>
                                        <input type="text" placeholder="NID Number" name="nid" value="{{ $partner->nid }}"
                                        class="form-control @error('nid') is-invalid @enderror" autocomplete="nid" required disabled>
                                        @error('nid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Address <span class="text-red">*</span></label>
                                        <input type="text" placeholder="Home Address" name="address" value="{{ $partner->address }}"
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
                                        <input type="text" placeholder="City" name="city" value="{{ $partner->city }}"
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
                                        <input type="number" class="form-control" placeholder="ZIP Code" name="zip_code" value="{{ $partner->postal_code }}"
                                        class="form-control @error('zip_code') is-invalid @enderror" autocomplete="zip_code">
                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-red">*</span></label>
                                        <select class="form-control custom-select select2" name="status" id="status" required>
                                            <option value="Active">Active</option>
                                            <option value="Pending" @if($partner->status == 'Pending') {{ 'selected' }} @endif>Pending</option>
                                            <option value="Reject">Reject</option>
                                        </select>
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
                                    <input type="file" class="dropify" data-height="240" name="profile_pic"/>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label text-center">NID</label>
                                    <input type="file" class="dropify" data-height="240" name="nid_pic"/>
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
                                    <label class="form-label text-center">Trade License</label>
                                    <input type="file" class="dropify" data-height="120" name="trade_license_pic"/>
                                </div>
                            </div>
                            <div class="row" style="height=60px !important">
                                <div class="col-lg-12 col-sm-12" style="height=60px !important">
                                    @error('trade_license_pic')
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
{{-- ! Admin or Moderator --}}
@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function(){
            $('.category-select').change(function(){
                $(this).find('option:selected').each(function(){
                    var optionValue = $(this).attr("value")

                    if(optionValue){
                        $(".hide").not("." + optionValue).hide()
                        $("." + optionValue).show()
                    } 
                    else {
                        $(".hide").hide()
                    }
                });
            }).change();

            adjustHeight()
            function adjustHeight() {
                var leftHeight = $('#left-card').height()
                var rightHeight = $('#right-card').height()

                if(leftHeight < rightHeight)
                    $('#left-card').height(rightHeight)
                if(leftHeight > rightHeight)
                    $('#right-card').height(leftHeight)
            }

            alertOnReject()
            function alertOnReject() {
                $(document).on('change', '#status', function() {
                    if($('#status').val() == 'Reject')
                        alert('Reject will delete this partner and all of this vehicles, drivers and assistants permanently. Are You sure?')
                })
            }
        });
    </script>
@endsection
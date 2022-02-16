@extends('master')

@section('header')
    @include('header')
@endsection

@section('body')
{{-- Admin --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" enctype="multipart/form-data" method="post">
            @csrf 
            @method('patch')
            <div class="side-app">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Status <span class="text-red">*</span></label>
                                            <select class="form-control custom-select select2" name="status" id="status" required>
                                                <option value="Active">Active</option>
                                                <option value="Pending" @if($vehicle->status == 'Pending') {{ 'selected' }} @endif>Pending</option>
                                                <option value="Reject">Reject</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex w-80">
                                        <div class="btn-list mx-auto">
                                            <button class="btn btn-pill btn-success px-5">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
{{-- ! Admin or Moderator --}}


{{-- Partner or Moderator--}}
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class)
|| Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" enctype="multipart/form-data" method="post">
            @csrf 
            @method('patch')
            <div class="side-app">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card" id="left-card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 category-parent">
                                        <div class="form-group">
                                            <label class="form-label">Vehicle Type <span class="text-red">*</span></label>
                                            <select class="form-control custom-select select2" name="vehicle_type" id="category-select">
                                                @foreach($categories->where('parent_id', 0) as $parent)
                                                <option value="{{ str_replace(' ', '_', $parent->name) }}"
                                                @if($vehicle->vehicle_type == $parent->name) {{ 'selected' }} @endif>
                                                    {{ $parent->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @foreach($categories->where('parent_id', 0) as $parent)
                                    <div class="col-md-6 col-sm-6 subcategory {{ str_replace(' ', '_', $parent->name) }}">
                                        <div class="form-group">
                                            <label class="form-label">SubCategory</label>
                                            <select class="form-control custom-select select2" name="{{ str_replace(' ', '_', $parent->name) }}">
                                                @foreach($categories->where('parent_id', $parent->id) as $child)
                                                <option value="{{ $child->name }}"
                                                    @if($vehicle->sub_category == $child->name) {{ 'selected' }} @endif>
                                                    {{ $child->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Vehicle Number <span class="text-red">*</span></label>
                                            <input type="text" name="vehicle_number" placeholder="Vehicle Number" value="{{ $vehicle->vehicle_number }}"
                                            class="form-control @error('vehicle_number') is-invalid @enderror" disabled>
                                            @error('vehicle_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Vehicle Color <span class="text-red">*</span></label>
                                            <input type="text" name="vehicle_color" placeholder="Vehicle Color" value="{{ $vehicle->vehicle_color }}"
                                            class="form-control @error('vehicle_color') is-invalid @enderror" required>
                                            @error('vehicle_color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Owner Name <span class="text-red">*</span></label>
                                            <input type="text" name="owner_name" placeholder="Owner Name"
                                            class="form-control @error('owner_name') is-invalid @enderror" value="{{ $vehicle->owner_name }}" required>
                                            @error('owner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Owner NID Number <span class="text-red">*</span></label>
                                            <input type="text" name="owner_nid" placeholder="Owner NID Number"
                                            class="form-control @error('owner_nid') is-invalid @enderror" value="{{ $vehicle->owner_nid }}" required>
                                            @error('owner_nid')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Owner Mobile Number <span class="text-red">*</span></label>
                                            <input type="text" name="owner_mobile" placeholder="Owner Mobile Number"
                                            class="form-control @error('owner_mobile') is-invalid @enderror" value="{{ $vehicle->owner_mobile }}" required>
                                            @error('owner_mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Owner Address <span class="text-red">*</span></label>
                                            <input type="text" name="owner_address" class="form-control" placeholder="Owner Address"
                                            class="form-control @error('owner_address') is-invalid @enderror" value="{{ $vehicle->owner_address }}" required>
                                            @error('owner_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @if(Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Status <span class="text-red">*</span></label>
                                            <select class="form-control custom-select select2" name="status" id="status" required>
                                                <option value="Active">Active</option>
                                                <option value="Pending" @if($vehicle->status == 'Pending') {{ 'selected' }} @endif>Pending</option>
                                                <option value="Reject">Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-12 d-flex w-80">
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
                                <div class="d-flex w-100">
                                    <h4 class="card-title mx-auto mb-3" style="text-decoration: underline">Vehicle Section</h4>
                                </div>
                            <div class="row"> 
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Vehicle Picture 1</label>
                                        <input type="file" class="dropify" data-height="70" name="vehicle_1_pic"/>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Vehicle Picture 2</label>
                                        <input type="file" class="dropify" data-height="70" name="vehicle_2_pic"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Smart Card</label>
                                        <input type="file" class="dropify" data-height="120" name="smart_card_pic"/>
                                    </div>
                                    
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Tax Token</label>
                                        <input type="file" class="dropify" data-height="120" name="tax_token_pic"/>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Fitness</label>
                                        <input type="file" class="dropify" data-height="120" name="fitness_pic"/>
                                    </div>
                                    
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Insurance</label>
                                        <input type="file" class="dropify" data-height="120" name="insurance_pic"/>
                                    </div>
                                </div>

                                <div class="d-flex w-100">
                                    <h4 class="card-title mx-auto mb-3" style="text-decoration: underline">Owner Section</h4>
                                </div>
                                <div class="row"> 
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Owner Picture</label>
                                        <input type="file" class="dropify" data-height="60" name="owner_profile_pic"/>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Owner NID Card</label>
                                        <input type="file" class="dropify" data-height="60" name="owner_nid_pic"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endif
{{-- ! Partner or Moderator --}}

@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function(){
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
            })

            alertOnReject()
            function alertOnReject() {
                $(document).on('change', '#status', function() {
                    if($('#status').val() == 'Reject')
                        alert('Reject will delete this vehicle permanently. Are You sure?')
                })
            }

                var defaultSub = $('#category-select').val()
                console.log(defaultSub)
                $('.subcategory').hide()
                $('.' + defaultSub).show()
                $(document).on('change', '#category-select', function(){
                    var sub = $(this).val()
                    $(this).parents('.category-parent').siblings('.subcategory').hide()
                    $(this).parents('.category-parent').siblings('.' + sub).show()               
                })
            //

        })
    </script>
@endsection
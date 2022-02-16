@extends('master')

@section('header')
@include('header')
@endsection

@section('body')
<!-- for Admin User -->
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <form action="{{ route('admin.setting.app.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card" id="left-card">
                            <div class="card-header">
                                <h3 class="card-title">Add App Setting</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Setting Name <span class="text-red">*</span></label>
                                            <input type="text" name="setting_name" placeholder="Setting Name" autofocus value="{{ old('setting_name') }}"
                                            class="form-control @error('setting_name') is-invalid @enderror" required>
                                            @error('setting_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">App Header <span class="text-red">*</span></label>
                                            <input type="text" name="App_Header" placeholder="App Header" autofocus value="{{ old('App_Header') }}"
                                            class="form-control @error('App_Header') is-invalid @enderror" autocomplete="App_Header" required>
                                            @error('App_Header')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Organigation Name <span class="text-red">*</span></label>
                                            <input type="text" name="Organigation_name" placeholder="Organization Name" autofocus value="{{ old('Organigation_name') }}"
                                            class="form-control @error('Organigation_name') is-invalid @enderror" autocomplete="Organigation_name" required>
                                            @error('Organigation_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Primary Button Color <span class="text-red">*</span></label>
                                            <input type="text" name="Button_Colour_primary" class="form-control color" value="maroon" required>
                                            @error('Button_Colour_primary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Secondary Button Color <span class="text-red">*</span></label>
                                            <input type="text" name="Button_Colour_Secondary" class="form-control color" value="lightgreen" required>
                                            @error('Button_Colour_Secondary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Primary Button Text <span class="text-red">*</span></label>
                                            <input type="text" name="Button_text_primary" class="form-control color" value="#40afcc" required>
                                            @error('Button_text_primary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Secondary Button Text <span class="text-red">*</span></label>
                                            <input type="text" name="Button_text_secondary" class="form-control color" value="#f39c12" required>
                                            @error('Button_text_secondary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Primary App Color <span class="text-red">*</span></label>
                                            <input type="text" name="App_colour_primary" class="form-control color" value="lightblue" required>
                                            @error('App_colour_primary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Secondary App Color <span class="text-red">*</span></label>
                                            <input type="text" name="App_colour_secondary" class="form-control color" value="coral" required>
                                            @error('App_colour_secondary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12 d-flex w-100 mt-5">
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
                                        <label class="form-label text-center">Splash Page</label>
                                        <input type="file" class="dropify" data-height="140" name="Splash_Page"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label text-center">Splash Screen</label>
                                        <input type="file" class="dropify" data-height="140" name="Splash_Screen"/>
                                    </div>
                                </div>
                                <div class="row" style="height=60px !important">
                                    <div class="col-lg-6 col-sm-12" style="height=60px !important">
                                        @error('Splash_Page')
                                        <label class="text-danger h-100" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        @error('Splash_Screen')
                                        <label class="text-danger h-100" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                        @enderror                               
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label text-center">App Logo</label>
                                        <input type="file" class="dropify" data-height="140" name="App_logo"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label text-center">Profile Image</label>
                                        <input type="file" class="dropify" data-height="140" name="Profile_image"/>
                                    </div>
                                </div>
                                <div class="row" style="height=60px !important">
                                    <div class="col-lg-6 col-sm-12" style="height=60px !important">
                                        @error('App_logo')
                                        <label class="text-danger h-100" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        @error('Profile_image')
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
<!-- for Admin Partner -->

@endsection

@section('footer')
    @include('footer')
    <script src="{{ asset('Html/assets/js/spectrum/spectrum.js') }}"></script>
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

            $(".color").spectrum({
                preferredFormat: "hex3",
                showInput: true,
            });
        })
    </script>
@endsection
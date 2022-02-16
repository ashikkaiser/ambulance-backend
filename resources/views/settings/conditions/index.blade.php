@extends('master')

@section('header')
    @include('header')
@endsection

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

</style>

@section('body')
    {{-- Admin Section --}}

    <div class="app-content main-content ">
        <div class="side-app">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12">

                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Select Policy To Edit</h3>
                            </div>
                            <div class="card-body">
                                <div class="wd-xl-100p ht-350">
                                    <div class="form-group">
                                        <label class="form-label">Select Policy <span class="text-red">*</span></label>
                                        <select class="form-control" id="policyselect">
                                            <option>Select one</option>
                                            <option value="user_policy">User Policy</option>
                                            <option value="user_tos">User Terms And Condition</option>
                                            <option value="driver_policy">Driver Policy</option>
                                            <option value="driver_tos">Driver Terms And Condition</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 user_policy">

                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Policy</h3>
                            </div>
                            <div class="card-body">
                                <div class="wd-xl-100p ht-350">
                                    <div class="ql-scrolling-demo bg-light p-4 border" id="scrolling-container">
                                        <div id="user_policy">
                                            {!! $conditions->user_policy !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 user_tos">

                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Terms and condition</h3>
                            </div>
                            <div class="card-body">
                                <div class="wd-xl-100p ht-350">
                                    <div class="ql-scrolling-demo bg-light p-4 border" id="scrolling-container">
                                        <div id="user_tos" class="quillInline">
                                            {!! $conditions->user_tos !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 driver_policy">

                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Driver Policy</h3>
                            </div>
                            <div class="card-body">
                                <div class="wd-xl-100p ht-350">
                                    <div class="ql-scrolling-demo bg-light p-4 border" id="scrolling-container">
                                        <div id="driver_policy" class="quillInline">
                                            {!! $conditions->driver_policy !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 driver_tos">

                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Driver Terms and condition</h3>
                            </div>
                            <div class="card-body">
                                <div class="wd-xl-100p ht-350">
                                    <div class="ql-scrolling-demo bg-light p-4 border" id="scrolling-container">
                                        <div id="driver_tos" class="quillInline">
                                            {!! $conditions->driver_tos !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <textarea style="display: none" id="user_policy1" name="user_policy">{!! $conditions->user_policy !!}</textarea>
                <textarea style="display: none" id="user_tos1" name="user_tos">{!! $conditions->user_tos !!}</textarea>
                <textarea style="display: none" id="driver_policy1" name="driver_policy">{!! $conditions->driver_policy !!}</textarea>
                <textarea style="display: none" id="driver_tos1" name="driver_tos">{!! $conditions->driver_tos !!}</textarea>
                <div class="btn-list mx-auto">
                    <button type="submit" name="submitPolicy" class="btn btn-pill btn-success px-5">Submit</button>
                </div>
            </form>

        </div>
    </div>


    {{-- ! Admin Section --}}
@endsection

@section('footer')
    @include('footer')

    <script>
        $(".user_policy").hide()
        $(".user_tos").hide()
        $(".driver_policy").hide()
        $(".driver_tos").hide()
        var policy = $("#policyselect")
        policy.on('change', function() {
            policy.val() == "user_policy" ? $(".user_policy").show() : $(".user_policy").hide()
            policy.val() == "user_tos" ? $(".user_tos").show() : $(".user_tos").hide()
            policy.val() == "driver_policy" ? $(".driver_policy").show() : $(".driver_policy").hide()
            policy.val() == "driver_tos" ? $(".driver_tos").show() : $(".driver_tos").hide()
        })
    </script>

    <script>
        var toolbarInlineOptions = [
            ['bold', 'italic', 'underline'],
            [{
                'header': 1
            }, {
                'header': 2
            }, 'blockquote'],
            ['link', 'image', 'code-block'],
        ];
        var user_policy = new Quill('#user_policy', {
            modules: {
                toolbar: toolbarInlineOptions
            },
            bounds: '#user_policy',
            scrollingContainer: '#scrolling-container',
            placeholder: 'Write something...',
            theme: 'bubble',
            name: "user_policy"
        });
        user_policy.on('text-change', function(delta, oldDelta, source) {
            $('#user_policy1').val(user_policy.container.firstChild.innerHTML);
        });
        var user_tos = new Quill('#user_tos', {
            modules: {
                toolbar: toolbarInlineOptions
            },
            bounds: '#user_tos',
            scrollingContainer: '#scrolling-container',
            placeholder: 'Write something...',
            theme: 'bubble',
            name: "user_tos"
        });
        user_tos.on('text-change', function(delta, oldDelta, source) {
            $('#user_tos1').val(user_tos.container.firstChild.innerHTML);
        });
        var driver_policy = new Quill('#driver_policy', {
            modules: {
                toolbar: toolbarInlineOptions
            },
            bounds: '#driver_policy',
            scrollingContainer: '#scrolling-container',
            placeholder: 'Write something...',
            theme: 'bubble',
            name: "driver_policy"
        });
        driver_policy.on('text-change', function(delta, oldDelta, source) {
            $('#driver_policy1').val(driver_policy.container.firstChild.innerHTML);
        });
        var driver_tos = new Quill('#driver_tos', {
            modules: {
                toolbar: toolbarInlineOptions
            },
            bounds: '#driver_tos',
            scrollingContainer: '#scrolling-container',
            placeholder: 'Write something...',
            theme: 'bubble',
            name: "driver_tos"
        });
        driver_tos.on('text-change', function(delta, oldDelta, source) {
            $('#driver_tos1').val(driver_tos.container.firstChild.innerHTML);
        });
    </script>

@endsection

@extends('master')

@section('header')
    @include('header')
@endsection
@section('body')
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                <div class="card">
                    <div class="card-header mb-4">
                        <div class="col-md-3">
                            <h3 class="card-title" style="flex-basis: 15%">Districts</h3>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">

                            <span class="input-group-append">
                                <button name="search_btn" class="btn btn-primary" data-toggle="modal"
                                    data-target="#districtsadd">Add Districts</button>
                            </span>
                        </div>
                    </div>

                    <div class="timeout">
                        @if ($message = Session::get('success'))
                            <div class="w-100 text-right">
                                <div class="alert alert-success mx-auto">
                                    <p>{{ $message }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="timeout">
                        @if ($message = Session::get('error'))
                            <div class="w-100 text-right">
                                <div class="alert alert-danger mx-auto">
                                    <p>{{ $message }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Name BN</th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($districts as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name_en }}</td>
                                            <td>{{ $item->name_bn }}</td>

                                            <td><a href="#" class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
        </div>
     




        <div class="modal fade" id="districtsadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Districts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form class="row" id="disadd">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-red">*</span></label>
                                    <input type="text" name="name" id="name" placeholder="Name" class="form-control"
                                        autocomplete="name" required="">
                                    <div class="invalid-feedback" id="name_error"> </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name Bangla <span class="text-red">*</span></label>
                                    <input type="text" name="mobile" placeholder="Name Bangla" value=""
                                        class="form-control " autocomplete="mobile" required="">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Latitude<span class="text-red">*</span></label>
                                    <input type="text" name="name" placeholder="Name" autofocus="" value=""
                                        class="form-control " autocomplete="name" required="">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Longitude<span class="text-red">*</span></label>
                                    <input type="text" name="mobile" placeholder="Name Bangla" value=""
                                        class="form-control " autocomplete="mobile" required="">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Zip Code<span class="text-red">*</span></label>
                                    <input type="text" name="mobile" placeholder="Name Bangla" value=""
                                        class="form-control " autocomplete="mobile" required="">
                                </div>
                            </div>



                            <div class="col-md-12 d-flex w-100">
                                <div class="btn-list mx-auto">
                                    <button class="btn btn-pill btn-success px-5" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('footer')
        @include('footer')
        <script>
            $("#disadd").submit(function(e) {
                e.preventDefault();
                addDistricts()
            });

            function addDistricts() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.fairmanagement.districts') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "field": "hello",
                        "addDistricts": true
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(reject) {
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            $.each(errors.errors, function(key, val) {
                                $("#" + key).addClass("is-invalid");
                                $("#" + key + "_error").text(val[0]);
                            });
                        }
                    }
                });
            }
        </script>

    @endsection

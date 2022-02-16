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
                            <h3 class="card-title" style="flex-basis: 15%">Fair Lists</h3>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <span class="input-group-append">
                                <button name="search_btn" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addLocation">Add Location</button>
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
                                        <th>Districts</th>
                                        <th>Location</th>
                                        <th>Location</th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td> 
                                            <td>{{ $item->district->name_en }}</td>
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



                    <div class="modal fade" id="addLocation" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Location</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form class="needs-validation row" id="locationForm" novalidate>
                                        @csrf
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">District
                                                    <span class="text-red">*</span>
                                                </label>
                                                <select class="form-group select2" name="district_id" id="" required>
                                                    @foreach ($districts as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name_en }} -
                                                            {{ $item->name_bn }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback" id="district_id_error"> </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Name English <span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="name_en" placeholder="Name English" value=""
                                                    class="form-control" autocomplete="mobile" required="">
                                                <div class="invalid-feedback" id="name_en_error"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Name Bangla <span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="name_bn" placeholder="Name Bangla" value=""
                                                    class="form-control " autocomplete="mobile" required="">
                                                <div class="invalid-feedback" id="name_bn_error"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Latitude<span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="lat" placeholder="Latitude" autofocus="" value=""
                                                    class="form-control" required="">
                                                <div class="invalid-feedback" id="lat_error"> </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Longitude<span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="long" placeholder="Longitude" value=""
                                                    class="form-control " autocomplete="mobile" required="">
                                                <div class="invalid-feedback" id="long_error"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Zip Code</label>
                                                <input type="text" name="postal_code" placeholder="Zip Code" value=""
                                                    class="form-control ">
                                                <div class="invalid-feedback" id="postal_code_error"> </div>
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


                </div><!-- bd -->
            </div>
        </div>
        <!-- End Row -->

    </div>
    </div>
@endsection

@section('footer')
    @include('footer')

    <script>
        $('#locationForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.fairmanagement.locations') }}",
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    location.reload()
                },
                error: function(reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        // alert(errors.message)
                        // console.log(errors)
                        
                        $.each(errors.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                            $("input[name=" + key + "]").addClass('is-invalid')
                        });
                    }
                }
            });




        })

        function addLocation(e) {
            e.preventDefault();

            // $.ajax({
            //     type: 'POST',
            //     url: "{{ route('admin.fairmanagement.locations') }}",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         "field": $('#field').cal()
            //     },
            //     success: function(data) {
            //         console.log(data);
            //     },
            //     error: function(reject) {
            //         if (reject.status === 422) {
            //             var errors = $.parseJSON(reject.responseText);
            //             console.log(errors)
            //             // $.each(errors, function(key, val) {
            //             //     $("#" + key + "_error").text(val[0]);
            //             // });
            //         }
            //     }
            // });
        }
    </script>

@endsection

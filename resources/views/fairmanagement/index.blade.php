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
                                    data-target="#districtsadd">Add Location</button>
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
                                        @foreach ($categories->where('parent_id', 0) as $item)
                                            <th>{{ $item->name }}</th>
                                        @endforeach
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fares as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->location->name_en }}</td>
                                            <td>{{ $item->location->district->name_en }}</td>
                                            @foreach ($item->rate as $cat)
                                                <td>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                @foreach ($cat as $key => $subcat)
                                                                    <th> {{ collect($categories)->firstWhere('id', $key)->name }}
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @foreach ($cat as $key => $subcat)
                                                                    <th> {{ $subcat }} </th>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            @endforeach
                                            <td><a href="#" class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <th>{{ ($drivers->currentPage() - 1) * $drivers->perPage() + $loop->index + 1 }}
                                            </th>
                                         
                                            <td>
                                                <strong>ID : </strong>{{ $driver->system_id }} <br>
                                                <strong>Name : </strong>{{ $driver->name }} <br>
                                                <strong>Mobile : </strong>{{ $driver->mobile }}
                                            </td>
                                            <td>{{ $driver->nid }}</td>
                                            <td>{{ $driver->driving_license }}</td>
                                            <td>{{ $driver->created_by }}</td>
                                            <td>{{ $driver->verified_by }}</td>
                                            @if ($driver->status == 'Pending')
                                                <td><span class="badge badge-warning mt-2">{{ $driver->status }}</span>
                                                </td>
                                            @else
                                                <td><span class="badge badge-success mt-2">{{ $driver->status }}</span>
                                                </td>
                                            @endif
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal"
                                                    data-target="{{ '#driver' . $driver->id }}">View</button></td>
                                            <td><a href="{{ route('admin.drivers.edit', $driver->id) }}"
                                                    class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div><!-- bd -->
                    </div><!-- bd -->



                    <div class="modal fade" id="districtsadd" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Fare</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form id="disadd" method="POST">
                                        @csrf

                                        <div class="row col-md-12">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Location
                                                        <span class="text-red">*</span>
                                                    </label>
                                                    <select class="form-group select2-show-search" name="location_id" id="">
                                                        @foreach ($locations as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_en }} -
                                                                {{ $item->district->name_en }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Category<span
                                                            class="text-red">*</span></label>
                                                    <select class="form-group select2" name="" id="categoryOnchange">
                                                        @foreach ($categories->where('parent_id', 0) as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}
                                        </div>


                                        {{-- <div id="appendform" class="row col-md-12">

                                        </div> --}}

                                        @foreach ($categories->where('parent_id', 0) as $item)
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">{{ $item->name }}</div>
                                                </div>
                                                <div class="card-header">
                                                    <div class="row col-md-12">
                                                        @foreach ($categories->where('parent_id', $item->id) as $subcat)
                                                            <div class="col-sm-6 col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">{{ $subcat->name }}
                                                                        <span class="text-red">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id . '[' . $subcat->id . ']' }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach



                                        <div class="col-md-12 d-flex w-100">
                                            <div class="btn-list mx-auto">
                                                <button class="btn btn-pill btn-success px-5" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>


                </div><!-- bd -->
            </div>
        </div>
        <!-- End Row -->

        {{-- <div class="pagination d-flex justify-content-center">{{ $drivers->links() }}</div> --}}

        {{-- <!-- Modal -->
        @foreach ($drivers as $driver)
            <div class="modal fade" id="driver{{ $driver->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $driver->system_id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table-bordered w-100">
                                            <tr>
                                                <td><strong>Name :</strong></td>
                                                <td>{{ $driver->name }}</td>
                                                <td><strong>Mobile :</strong></td>
                                                <td>{{ $driver->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NID Number :</strong></td>
                                                <td>{{ $driver->nid }}</td>
                                                <td><strong>Driving License :</strong></td>
                                                <td>{{ $driver->driving_license }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Address :</strong></td>
                                                <td>{{ $driver->address . ', ' . $driver->city . ', ' . $driver->postal_code }}
                                                </td>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $driver->status }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Created By :</strong></td>
                                                <td>{{ $driver->created_by }}</td>
                                                <td><strong>Verified By :</strong></td>
                                                <td>{{ $driver->verified_by }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Profile Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px"
                                            src="{{ asset('images/driver_picture/' . $driver->nid . '/' . $driver->profile_pic) }}">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">NID Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px"
                                            src="{{ asset('images/driver_picture/' . $driver->nid . '/' . $driver->nid_pic) }}">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Driving License Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px"
                                            src="{{ asset('images/driver_picture/' . $driver->nid . '/' . $driver->driving_license_pic) }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>
    </div>
@endsection

@section('footer')
    @include('footer')

    <script>
        // getSubcategory()

        // $('#categoryOnchange').on('change', function() {
        //     getSubcategory($(this).val())
        // })
        // getSubcategory()

        // function getSubcategory() {
        //     $('#appendform').html(null)
        //     var category = JSON.parse('{{ $categories }}'.replace(/&quot;/g, '"'))
        //     // var fCategory = category.filter(cat => cat.parent_id === id)
        //     // $.each(fillterdCategory, function(key, val) {

        //     //     var html = '<div class="col-sm-6 col-md-6"><div class="form-group">' +
        //     //         '<label class="form-label">' + val.name + '<span class="text-red">*</span></label>' +
        //     //         '<input type="text" name="mobile" placeholder="' + val.name + '" value="" ' +
        //     //         'class="form-control " autocomplete="mobile" required="">' +
        //     //         '</div>' +
        //     //         '</div>'

        //     //     $('#appendform').append(html)
        //     //     console.log(val)
        //     // })
        // }



        function addDistricts() {


            $.ajax({
                type: 'POST',
                url: "{{ route('admin.fairmanagement.districts') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "field": $('#field').cal()
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        console.log(errors)
                        // $.each(errors, function(key, val) {
                        //     $("#" + key + "_error").text(val[0]);
                        // });
                    }
                }
            });
        }
    </script>

@endsection

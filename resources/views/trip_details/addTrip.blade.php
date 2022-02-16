@extends('master')

@section('header')

    @include('header')

@endsection

@section('body')
    @if (Auth::guard('admin_user')->user()->can('haveAgentAccess', App\Models\AdminUser::class))
        <div class="app-content main-content">
            @csrf
            @method('post')
            <div class="side-app">

                <form action="{{ route('admin.TripDetails.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="card" id="left-card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Trip</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 category-parent">
                                            <div class="form-group">
                                                <label class="form-label">Vehicle Type <span
                                                        class="text-red">*</span></label>
                                                <select class="form-control custom-select select2" name="vehicle_type"
                                                    id="category-select">
                                                    @foreach ($categories->where('parent_id', 0) as $parent)
                                                        <option value="{{ str_replace(' ', '_', $parent->name) }}">
                                                            {{ $parent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @foreach ($categories->where('parent_id', 0) as $parent)
                                            <div
                                                class="col-md-6 col-sm-6 subcategory {{ str_replace(' ', '_', $parent->name) }}">
                                                <div class="form-group">
                                                    <label class="form-label">SubCategory</label>
                                                    <select class="form-control custom-select select2 subcatValue"
                                                        name="veiclesCategory">
                                                        @foreach ($categories->where('parent_id', $parent->id) as $child)
                                                            <option value="{{ $child->id }}">{{ $child->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">User Name <span class="text-red">*</span></label>
                                                <input type="text" name="user_name" placeholder="User Name"
                                                    value="{{ old('user_name') }}"
                                                    class="form-control @error('user_name') is-invalid @enderror" required>
                                                @error('user_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Mobile Number <span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="mobile" placeholder="Mobile Number"
                                                    value="{{ old('mobile') }}"
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
                                                <label class="form-label">Nid Number <span class="text-red">*</span></label>
                                                <input type="text" name="nid_number" placeholder="Nid Number"
                                                    class="form-control @error('nid_number') is-invalid @enderror"
                                                    value="{{ old('nid_number') }}" required>
                                                @error('nid_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Destination <span
                                                        class="text-red">*</span></label>
                                                <input type="text" name="destination" id="pac-input"
                                                    placeholder="Destination"
                                                    class="form-control destination1 @error('destination') is-invalid @enderror"
                                                    value="{{ old('destination') }}" required>
                                                @error('destination')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 d-flex w-80">
                                            <div class="btn-list mx-auto">
                                                <td>
                                                    <a class="btn btn-pill btn-success px-5 preview" data-toggle="modal" data-target="#trip">Preview</a>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->

                        <div class="modal fade" id="trip" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Trip Preview</h5>
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
                                                            <td><strong>Pickup Point :</strong></td>
                                                            <td>Dhaka Medical College Hospital</td>
                                                            <td><strong>Destination :</strong></td>
                                                            <td class="destination2"
                                                                style="width: 30% !important;flex-wrap: wrap;">Khulna</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Estimated Distance :</strong></td>
                                                            <td class="estdist"></td>
                                                            <td><strong>Estimated Time :</strong></td>
                                                            <td class="esttime"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Estimated Govt. Fair :</strong></td>
                                                            <td>&#2547; <x class="estgovtfair"></x>
                                                            </td>
                                                            <td><strong>Discount :</strong></td>
                                                            <td>&#2547; <x class="discount"></x>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Final Estimated Fair :</strong></td>
                                                            <td style="color: green; font-weight: 900;">&#2547; <x
                                                                    class="estfair"></x>
                                                            </td>

                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="estimated_time" class="estimated_time" />
                                    <input type="hidden" name="estimated_distance" class="estimated_distance" />
                                    <input type="hidden" name="estimated_fair" class="estimated_fair" />
                                    <input type="hidden" name="end_lat_long[]" class="end_lat" />
                                    <input type="hidden" name="end_lat_long[]" class="end_long" />
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="map"></div>


        </div>

    @endif
@endsection
@section('footer')
    @include('footer')
    <script>
        $(document).ready(function() {
            $('.subcategory').hide()
            $('.subcategory').first().show()
            $(document).on('change', '#category-select', function() {
                var sub = $(this).val()
                $(this).parents('.category-parent').siblings('.subcategory').hide()
                $(this).parents('.category-parent').siblings('.' + sub).show()
            })
        })

        const input = document.getElementById("pac-input");

        function initAutocomplete() {
            const options = {
                componentRestrictions: {
                    country: "bd"
                },
                fields: ["address_components", "geometry", "icon", "name"],
                strictBounds: false,
                types: ["establishment"],
            };
            const searchBox = new google.maps.places.Autocomplete(input, options);
            searchBox.addListener('place_changed', function() {
                var place = searchBox.getPlace();
                place.address_components.forEach((res) => {
                    const finding = res.types.find((element) => element === "administrative_area_level_2");
                    if (finding !== undefined) {
                        console.log(res.short_name)
                    }
                })
                var lat = place.geometry.location.lat(),
                    lng = place.geometry.location.lng();
                fetch("{{ route('admin.TripDetails.calculation') }}", {

                        method: "POST",
                        credentials: "same-origin",
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            latlong: `${lat} , ${lng}`,
                            subcat: $(".subcatValue").val()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        $(".estdist").text(data.distance)
                        $(".esttime").text(data.time)
                        $(".estfair").text(data.finalFair)
                        $(".discount").text(data.discount)
                        $(".estgovtfair").text(data.fairInKm)
                        $(".estimated_time").val(data.time)
                        $(".estimated_fair").val(data.finalFair)
                        $(".estimated_distance").val(data.distance)
                        $(".end_lat").val(lat)
                        $(".end_long").val(lng)
                    });

                if (!place.geometry || !place.geometry.location) {
                    console.log("No details available for input: '" + place.name + "'");
                    return;
                }
            });
        }
        $(".preview").on("click", function() {
            $(".destination2").text(input.value.replace(", Bangladesh", ""))
        })
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9NjyJPS6SI3x2hK1LueRQb74RHlQnjiU&callback=initAutocomplete&libraries=places&v=weekly">
    </script>
@endsection

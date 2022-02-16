@extends('master')

@section('header')
    @include('header')
@endsection

@section('body')
{{-- Admin or Moderator --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class)
|| Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header mb-4">
                            <div class="col-md-3">
                                <h3 class="card-title" style="flex-basis: 15%">Vehicle list</h3>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.vehicles.index') }}" class="input-group align-items-center">
                                    @csrf
                                    <input type="text" name="search" class="form-control" placeholder="Search by vehicle or partner information"
                                    value="">
                                    <span class="input-group-append">
                                        <button name="search_btn" class="btn btn-primary">Go!</button>
                                    </span>
                                </form>
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
                                            <th>Vehicle ID</th>
                                            <th>Vehicle Number</th>
                                            <th>Partner</th>
                                            <th>Parent Category</th>
                                            <th>Sub Category</th>
                                            <th>Accident History</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Verified By</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ ($vehicles->currentPage()-1) * $vehicles->perPage() + $loop->index + 1}}</th>
                                            <td>{{ $vehicle->system_id }}</td>
                                            <td>{{ $vehicle->vehicle_number }}</td>
                                            <td>
                                                <strong>Name : </strong>{{ $vehicle->partner->name }} <br>
                                                <strong>Mobile : </strong>{{ $vehicle->partner->mobile }} <br>
                                                <strong>Address : </strong>{{ $vehicle->partner->address . ', ' . $vehicle->partner->city}}
                                            </td>
                                            <td>{{ $vehicle->vehicle_type }}</td>
                                            <td>{{ $vehicle->sub_category }}</td>
                                            <td>{{ $vehicle->accident_history }}</td>
                                            @if($vehicle->status == 'Active')
                                                <td><span class="badge badge-success mt-2" >{{ $vehicle->status }}</span></td>
                                            @else
                                                <td><span class="badge badge-warning mt-2" >{{ $vehicle->status }}</span></td>
                                            @endif
                                            <td>{{ $vehicle->created_by }}</td>
                                            <td>{{ $vehicle->verified_by }}</td>
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#vehicle' . $vehicle->id }}">View</button></td>
                                            <td><a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div>
            </div>
            <!-- End Row -->
            
            <div class="pagination d-flex justify-content-center">{{ $vehicles->links() }}</div>

            <!-- Modal -->
            @foreach($vehicles as $vehicle)
            <div class="modal fade" id="vehicle{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $vehicle->system_id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Vehicle Picture : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->vehicle_1_pic) }}" 
                                        class="img-fluid w-100" style="height: 47%">
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->vehicle_2_pic) }}" 
                                        class="img-fluid w-100 mt-2" style="height: 47%">
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table-bordered w-100">
                                            <label class="form-label"><strong>Vehicle Information : </strong></label>
                                            <tr>
                                                <td><strong>Vehicle ID :</strong></td>
                                                <td>{{ $vehicle->system_id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Number :</strong></td>
                                                <td>{{ $vehicle->vehicle_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Category :</strong></td>
                                                <td>{{ $vehicle->vehicle_type }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Sub Category :</strong></td>
                                                <td>{{ $vehicle->sub_category }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Color :</strong></td>
                                                <td>{{ $vehicle->vehicle_color }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Name :</strong></td>
                                                <td>{{ $vehicle->owner_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Mobile :</strong></td>
                                                <td>{{ $vehicle->owner_mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner NID :</strong></td>
                                                <td>{{ $vehicle->owner_nid }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Address :</strong></td>
                                                <td>{{ $vehicle->owner_address }}</td>
                                            </tr>  
                                            @foreach($vehicle->drivers as $driver)                                        
                                            <tr>
                                                <td><strong>Driver {{ $loop->index + 1 }} :</strong></td>
                                                <td>{{ $driver->name }} <br> {{ $driver->mobile }}</td>
                                            </tr>
                                            @endforeach
                                            @foreach($vehicle->assistants as $assis)                                        
                                            <tr>
                                                <td><strong>Assistant {{ $loop->index + 1 }} :</strong></td>
                                                <td>{{ $assis->name }} <br> {{ $assis->mobile }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td><strong>Prefered Destination :</strong></td>
                                                <td>{{ $vehicle->preferred_destination }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $vehicle->status }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Created By :</strong></td>
                                                <td>{{ $vehicle->created_by }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Verified By :</strong></td>
                                                <td>{{ $vehicle->verified_by }}</td>
                                            </tr>
                                        </table>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Owner : </strong></label>
                                                <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->owner_profile_pic) }}" 
                                                class="img-fluid w-100 ">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Owner NID : </strong></label>
                                                <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->owner_nid_pic) }}" 
                                                class="img-fluid w-100 ">
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Smart Card : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->smart_card_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Tax Token : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->tax_token_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Fitness : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->fitness_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Insurance : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->insurance_pic) }}" 
                                        class="img-fluid w-100 h-100">
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
            @endforeach
        </div>
    </div>
@endif
{{-- ! Admin or Moderator --}}

{{-- Partner --}}
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header mb-4">
                            <div class="col-md-3">
                                <h3 class="card-title" style="flex-basis: 15%">Vehicle list</h3>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.vehicles.index') }}" class="input-group align-items-center">
                                    @csrf
                                    <input type="text" name="search" class="form-control" placeholder="Search by vehicle information"
                                    value="">
                                    <span class="input-group-append">
                                        <button name="search_btn" class="btn btn-primary">Go!</button>
                                    </span>
                                </form>
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

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped card-table table-vcenter text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Vehicle ID</th>
                                            <th>Vehicle Number</th>
                                            <th>Owner</th>
                                            <th>Accident History</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ ($vehicles->currentPage()-1) * $vehicles->perPage() + $loop->index + 1}}</th>
                                            <td>{{ $vehicle->system_id }}</td>
                                            <td>{{ $vehicle->vehicle_number }}</td>
                                            <td>
                                                <strong>Name : </strong>{{ $vehicle->owner_name }} <br>
                                                <strong>Mobile : </strong>{{ $vehicle->owner_mobile }} <br>
                                                <strong>Address : </strong>{{ $vehicle->owner_address }}
                                            </td>
                                            <td>{{ $vehicle->accident_history }}</td>
                                            @if($vehicle->status == 'Active')
                                            <td><span class="badge badge-success mt-2" >{{ $vehicle->status }}</span></td>
                                            @else
                                                <td><span class="badge badge-warning mt-2" >{{ $vehicle->status }}</span></td>
                                            @endif
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#vehicle' . $vehicle->id }}">View</button></td>
                                            <td><a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                            <td>
                                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST"> 
                                                    @method('DELETE')                                                   
                                                    @csrf
                                                    <button class="btn btn-pill btn-danger btn-sm delete-btn">Delete</button>
                                                </form>    
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
            <!-- End Row -->

            <div class="pagination d-flex justify-content-center">{{ $vehicles->links() }}</div>

            <!-- Modal -->
            @foreach($vehicles as $vehicle)
            <div class="modal fade" id="vehicle{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $vehicle->system_id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Vehicle Picture : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->vehicle_1_pic) }}" 
                                        class="img-fluid w-100" style="height: 47%">
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->vehicle_2_pic) }}" 
                                        class="img-fluid w-100 mt-2" style="height: 47%">
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table-bordered w-100">
                                            <label class="form-label"><strong>Vehicle Information : </strong></label>
                                            <tr>
                                                <td><strong>Vehicle ID :</strong></td>
                                                <td>{{ $vehicle->system_id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Number :</strong></td>
                                                <td>{{ $vehicle->vehicle_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Category :</strong></td>
                                                <td>{{ $vehicle->vehicle_type }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Sub Category :</strong></td>
                                                <td>{{ $vehicle->sub_category }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Vehicle Color :</strong></td>
                                                <td>{{ $vehicle->vehicle_color }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Name :</strong></td>
                                                <td>{{ $vehicle->owner_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Mobile :</strong></td>
                                                <td>{{ $vehicle->owner_mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner NID :</strong></td>
                                                <td>{{ $vehicle->owner_nid }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Owner Address :</strong></td>
                                                <td>{{ $vehicle->owner_address }}</td>
                                            </tr>  
                                            @foreach($vehicle->drivers as $driver)                                        
                                            <tr>
                                                <td><strong>Driver {{ $loop->index + 1 }} :</strong></td>
                                                <td>{{ $driver->name }} <br> {{ $driver->mobile }}</td>
                                            </tr>
                                            @endforeach
                                            @foreach($vehicle->assistants as $assis)                                        
                                            <tr>
                                                <td><strong>Assistant {{ $loop->index + 1 }} :</strong></td>
                                                <td>{{ $assis->name }} <br> {{ $assis->mobile }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td><strong>Prefered Destination :</strong></td>
                                                <td>{{ $vehicle->preferred_destination }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $vehicle->status }}</td>
                                            </tr>
                                        </table>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Owner : </strong></label>
                                                <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->owner_profile_pic) }}" 
                                                class="img-fluid w-100 ">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Owner NID : </strong></label>
                                                <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->owner_nid_pic) }}" 
                                                class="img-fluid w-100 ">
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Smart Card : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->smart_card_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Tax Token : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->tax_token_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Fitness : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->fitness_pic) }}" 
                                        class="img-fluid w-100 h-100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><strong>Insurance : </strong></label>
                                        <img src="{{ asset('images/vehicle_picture/' . $vehicle->vehicle_number . '/' . $vehicle->picture->insurance_pic) }}" 
                                        class="img-fluid w-100 h-100">
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
            @endforeach
        </div>
    </div>
@endif
{{-- ! Partner --}}

@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function() {
            setTimeout(function() { 
                $('.timeout').hide(); 
            }, 5000);

            alertOnReject()
            function alertOnReject() {
                $(document).on('click', '.delete-btn', function(e){
                    e.preventDefault()
                    if(confirm("Are you sure to delete this vehicle?")) {
                        $(this).parent('form').submit()
                    }
                })
            }
        })
    </script>
@endsection
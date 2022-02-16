@extends('master')

@section('header')
    @include('header')
@endsection

@section('body')

<div class="app-content main-content" style="max-width: 100%">
    <div class="side-app">
        <!-- Row -->
        <div class="row">
                <div class="card">
                    <div class="card-header mb-4">
                        <div class="col-md-3">
                            <h3 class="card-title" style="flex-basis: 15%">Trip Details</h3>
                        </div>

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.tripDetails.list') }}" class="input-group align-items-center" method="post">
                                @csrf
                                <input type="text" name="search" class="form-control" placeholder="Search by Booking Id"
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

                    <div class="timeout">
                        @error('trip_amount')
                        <div class="w-100 text-right">
                            <div class="alert alert-danger mx-auto">
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                        @enderror
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Booking ID</th>
                                        <th>Date</th>
                                        <th>Vehicle Number</th>
                                        <th>Driver Name</th>
                                        <th>User Name</th>
                                        <th>Cancelled By</th>
                                        <th>Est Distance</th>
                                        <th>Est Fair</th>
                                        <th>Trip Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tripDetails as $trip)
                                    <tr>
                                        <td>{{ ($tripDetails->currentPage()-1) * $tripDetails->perPage() + $loop->index + 1}}</td>
                                        <td>DMBK# {{ $trip->booking_id }}</td>
                                        <td>{{ $trip->booking_date->format('d F, Y') }}</td>
                                        <td>{{ isset($trip->vehicle->vehicle_number)? $trip->vehicle->vehicle_number:"" }}</td>
                                        <td>{{ isset($trip->driver->name)? $trip->driver->name:"" }}</td>
                                        <td>{{ $trip->getUser->name }}</td>
                                        <td>{{ $trip->cancelled_by }}</td>
                                        <td>{{ $trip->estimated_distance . ' ' }}km</td>
                                        <td>&#2547; {{ $trip->estimated_fair }}</td>
                                        <td>{{ $trip->booking_status }}</td>
                                        <td><button class="btn btn-pill btn-success" data-toggle="modal" data-target="{{ '#trip' . $trip->id }}">View</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

        <div class="pagination d-flex justify-content-around">{{ $tripDetails->links() }}</div>

        <!-- Modal -->
        @foreach($tripDetails as $trip)
        <div class="modal fade" id="trip{{ $trip->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Booking ID: DMBK#{{ $trip->booking_id }}</h5>
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
                                            <td><strong>Booking ID :</strong></td>
                                            <td>DMBK#{{ $trip->booking_id }}</td>
                                            <td><strong>Trip Date :</strong></td>
                                            <td>{{ $trip->booking_date->format('d F, Y H:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Vehicle ID :</strong></td>
                                            <td>{{ isset($trip->vehicle->system_id)?$trip->vehicle->system_id:""}}</td>
                                            <td><strong>Vehicle Number :</strong></td>
                                            <td>{{ isset($trip->vehicle->vehicle_number)?$trip->vehicle->vehicle_number:"" }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Driver Name :</strong></td>
                                            <td>{{ isset($trip->driver->name)?$trip->driver->name:"" }}</td>
                                            <td><strong>Driver Mobile :</strong></td>
                                            <td>{{ isset($trip->driver->mobile)?$trip->driver->mobile:"" }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Name :</strong></td>
                                            <td>{{ $trip->getUser->name }}</td>
                                            <td><strong>User Mobile :</strong></td>
                                            <td>{{ $trip->getUser->mobile }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Start Point :</strong></td>
                                            <td>{{ $trip->start_point }}</td>
                                            <td><strong>End Point :</strong></td>
                                            <td>{{ $trip->end_point }}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Estimated Time :</strong></td>
                                            <td>{{ $trip->estimated_time }}</td>
                                            <td><strong>Estimated Distance :</strong></td>
                                            <td>{{ $trip->estimated_distance }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Estimated Fair :</strong></td>
                                            <td>{{ $trip->estimated_fair }}</td>
                                            <td><strong>Booking Status :</strong></td>
                                            <td>{{ $trip->booking_status }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Booking OTP :</strong></td>
                                            <td>{{ $trip->booking_otp}}</td>
                                            <td><strong>Cancelled By :</strong></td>
                                            <td>{{ $trip->cancelled_by }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Final Distance :</strong></td>
                                            <td>{{ $trip->final_distance }}</td>
                                            <td><strong>Payment Method :</strong></td>
                                            <td>{{ $trip->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Final Fair :</strong></td>
                                            <td>{{ $trip->final_fair }}</td>
                                            <td><strong>Discount Amount :</strong></td>
                                            <td>{{ $trip->discount_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Net Payment :</strong></td>
                                            <td>{{ $trip->accident_history }}</td>
                                            <td><strong>Trip Feedback :</strong></td>
                                            <td>{{ $trip->trip_feedback }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if(Auth::guard('admin_user')->user()->can('haveAgentAccess', \App\Models\AdminUser::class))

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-9">
                                    <form action="{{ route('admin.tripDetails.list.submit', $trip->id) }}" class="" method="POST">
                                        @csrf
                                        @method('post')
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="col-12">
                                                    <label class="form-label">Collect Trip Amount <span class="text-red">*</span></label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control mr-3" name="trip_amount" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-5">
                                                <button class="btn btn-info mr-5">Submit</button>
                                            </div>
                                            <div class="col-md-3 mt-5">
                                                <button class="btn btn-success ml-5">Print</button>
                                            </div>
                                        </div>                                                                         
                                    </form>                    
                                </div>

                                <div class="col-md-3 text-right mt-5">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                                </div>
                            </div>
                        </div>

                        @endif
                        @if(Auth::guard('admin_user')->user()->cannot('haveAgentAccess', \App\Models\AdminUser::class))
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                        @endif                       
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function() {
            setTimeout(function() { 
                $('.timeout').hide(); 
            }, 5000);
        })
    </script>
@endsection
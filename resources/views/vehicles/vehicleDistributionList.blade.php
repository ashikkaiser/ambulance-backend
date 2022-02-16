@extends('master')

@section('header')
@include('header')
@endsection

@section('body')

{{-- Vehicle List for Partner --}}
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Vehicle Distribution</h3>
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
                                            <th>Driver</th>
                                            <th>Assistant</th>
                                            <th>Driver Distribution</th>
                                            <th>Asst Distribution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehicles as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $item->system_id }}</td>
                                            <td>{{ $item->vehicle_number }}</td>
                                            <td style="vertical-align : top">
                                                @foreach($item->drivers()->get() as $driver)
                                                    <strong>{{ 'Driver ' . $loop->index + 1 . ':'  }}</strong> <br>
                                                    {{ 'Name: ' . $driver->name }} <br>
                                                    {{ 'Mobile: ' . $driver->mobile }} <br><br>
                                                @endforeach
                                            </td>
                                            <td style="vertical-align : top">
                                                @foreach($item->assistants()->get() as $ass)
                                                <strong>{{ 'Assistant ' . $loop->index + 1 . ':'  }}</strong> <br>
                                                {{ 'Name: ' . $ass->name }} <br>
                                                {{ 'Mobile: ' . $ass->mobile }} <br><br>
                                                @endforeach     
                                            </td>
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#driver' . $item->id }}">Add/Remove</button></td>
                                            <td><button class="btn btn-pill btn-primary btn-sm" data-toggle="modal" data-target="{{ '#assistant' . $item->id }}">Add/Remove</button></td>
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

            <!-- Modal for Add/Remove Driver -->
            @foreach($vehicles as $item)
            <form action="{{ route('admin.vehicle.distribution.save', $item->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="driver">
                <div class="modal fade" id="driver{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $item->system_id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 any">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Action <span class="text-red">*</span></strong></label>
                                                <select class="action form-control custom-select select2 @error('action') is-invalid @enderror"
                                                 name="action" required>
                                                    <option value="">Select Action</option>
                                                    <option value="Add">Add</option>
                                                    <option value="Remove">Remove</option>
                                                </select>
                                                @error('action')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 hide Add">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Add Driver </strong></label>
                                                <select class="form-control custom-select select2 @error('add') is-invalid @enderror" name="add">
                                                    <option value="">Select Driver</option>
                                                    @foreach($unAssignedDrivers as $nod)
                                                    <option value="{{ $nod->id }}">{{ $nod->name . '(' . $nod->system_id . ')' }}</option>
                                                    @endforeach
                                                </select>
                                                @error('add')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 hide Remove">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Remove Driver </strong></label>
                                                <select class="form-control custom-select select2 @error('add') is-invalid @enderror" name="remove">
                                                    <option value="">Select Driver</option>
                                                    @foreach($item->drivers()->get() as $nod)
                                                    <option value="{{ $nod->id }}">{{ $nod->name . '(' . $nod->system_id . ')' }}</option>
                                                    @endforeach
                                                </select>
                                                @error('add')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endforeach
            <!-- !Modal for Add/Remove Driver -->

            <!-- Modal for Add/Remove Assistant -->
            @foreach($vehicles as $item)
            <form action="{{ route('admin.vehicle.distribution.save', $item->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="assistant">
                <div class="modal fade" id="assistant{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $item->system_id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 any">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Action <span class="text-red">*</span></strong></label>
                                                <select class="action form-control custom-select select2 @error('action') is-invalid @enderror"
                                                 name="action" required>
                                                    <option value="">Select Action</option>
                                                    <option value="Add">Add</option>
                                                    <option value="Remove">Remove</option>
                                                </select>
                                                @error('action')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 hide Add">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Add Assistant </strong></label>
                                                <select class="form-control custom-select select2 @error('add') is-invalid @enderror" name="add">
                                                    <option value="">Select Assistant</option>
                                                    @foreach($unAssignedAssistants as $nod)
                                                    <option value="{{ $nod->id }}">{{ $nod->name . '(' . $nod->system_id . ')' }}</option>
                                                    @endforeach
                                                </select>
                                                @error('add')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 hide Remove">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Remove Assistant </strong></label>
                                                <select class="form-control custom-select select2 @error('add') is-invalid @enderror" name="remove">
                                                    <option value="">Select Assistant</option>
                                                    @foreach($item->assistants()->get() as $nod)
                                                    <option value="{{ $nod->id }}">{{ $nod->name . '(' . $nod->system_id . ')' }}</option>
                                                    @endforeach
                                                </select>
                                                @error('add')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endforeach
            <!-- !Modal for Add/Remove Assistant -->
        </div>
    </div>
@endif
{{-- ! Vehicle List for Partner --}}

@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function(){
            $('.hide').hide()
            $(document).on('change', '.action', function(){
                var value = $(this).val();
                if(value !== '') {
                    $(this).parents('.any').siblings('.hide').hide()
                    $(this).parents('.any').siblings('.' + value).show()
                }
            })

            setTimeout(function() { 
                $('.timeout').hide(); 
            }, 5000);
        });
    </script>
@endsection
@extends('master')

@section('header')
@include('header')
@endsection

@section('body')

{{-- Admin || Moderator --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class)
|| Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header mb-4">
                            <div class="col-md-3">
                                <h3 class="card-title" style="flex-basis: 15%">Assistant list</h3>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.assistants.index') }}" class="input-group align-items-center">
                                    @csrf
                                    <input type="text" name="search" class="form-control" placeholder="Search by assistant or partner information"
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
                                            {{-- <th>Partner</th> --}}
                                            <th>Assistant</th>
                                            <th>NID</th>
                                            <th>DL</th>
                                            <th>Created By</th>
                                            <th>Verified By</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assistants as $assistant)
                                        <tr>
                                            <th>{{ ($assistants->currentPage()-1) * $assistants->perPage() + $loop->index + 1}}</th>
                                            {{-- <td>
                                                <strong>ID : </strong>{{ $assistant->partner->system_id }} <br>
                                                <strong>Name : </strong>{{ $assistant->partner->name }} <br>
                                                <strong>Mobile : </strong>{{ $assistant->partner->mobile }}
                                            </td> --}}
                                            <td>
                                                <strong>ID : </strong>{{ $assistant->system_id }} <br>
                                                <strong>Name : </strong>{{ $assistant->name }} <br>
                                                <strong>Mobile : </strong>{{ $assistant->mobile }}
                                            </td>
                                            <td>{{ $assistant->nid }}</td>
                                            <td>{{ $assistant->driving_license }}</td>
                                            <td>{{ $assistant->created_by }}</td>
                                            <td>{{ $assistant->verified_by }}</td>
                                            @if($assistant->status == 'Pending')
                                                <td><span class="badge badge-warning mt-2" >{{ $assistant->status }}</span></td>
                                            @else
                                                <td><span class="badge badge-success mt-2" >{{ $assistant->status }}</span></td>
                                            @endif
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#assistant' . $assistant->id }}">View</button></td>
                                            <td><a href="{{ route('admin.assistants.edit', $assistant->id) }}" class="btn btn-pill btn-info btn-sm">Modify</a></td>
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

            <div class="pagination d-flex justify-content-center">{{ $assistants->links() }}</div>

            <!-- Modal -->
            @foreach($assistants as $assistant)
            <div class="modal fade" id="assistant{{ $assistant->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $assistant->system_id }}</h5>
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
                                                <td>{{ $assistant->name }}</td>
                                                <td><strong>Mobile :</strong></td>
                                                <td>{{ $assistant->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NID Number :</strong></td>
                                                <td>{{ $assistant->nid }}</td>
                                                <td><strong>Driving License :</strong></td>
                                                <td>{{ $assistant->driving_license }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Address :</strong></td>
                                                <td>{{ $assistant->address . ', ' . $assistant->city . ', ' . $assistant->postal_code }}</td>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $assistant->status }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Created By :</strong></td>
                                                <td>{{ $assistant->created_by }}</td>
                                                <td><strong>Verified By :</strong></td>
                                                <td>{{ $assistant->verified_by }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Profile Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->profile_pic) }}">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">NID Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->nid_pic) }}">
                                    </div> 
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Driving License Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->driving_license_pic) }}">
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
{{-- ! Admin || Moderator --}}


{{-- Partner --}}
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header mb-4">
                            <div class="col-md-3">
                                <h3 class="card-title" style="flex-basis: 15%">Assistant list</h3>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.assistants.index') }}" class="input-group align-items-center">
                                    @csrf
                                    <input type="text" name="search" class="form-control" placeholder="Search by assistant information"
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
                                            <th>Assistant ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>NID</th>
                                            <th>DL</th>
                                            <th>Adress</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assistants as $assistant)
                                        <tr>
                                            <th>{{ ($assistants->currentPage()-1) * $assistants->perPage() + $loop->index + 1}}</th>
                                            <td>{{ $assistant->system_id }}</td>
                                            <td>{{ $assistant->name }}</td>
                                            <td>{{ $assistant->mobile }}</td>
                                            <td>{{ $assistant->nid }}</td>
                                            <td>{{ $assistant->driving_license }}</td>
                                            <td>{{ $assistant->address . ', ' . $assistant->city . ', ' . $assistant->postal_code }}</td>
                                            @if($assistant->status == 'Pending')
                                                <td><span class="badge badge-warning mt-2" >{{ $assistant->status }}</span></td>
                                            @else
                                                <td><span class="badge badge-success mt-2" >{{ $assistant->status }}</span></td>
                                            @endif
                                            <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#assistant' . $assistant->id }}">View</button></td>
                                            <td><a href="{{ route('admin.assistants.edit', $assistant->id) }}" class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                            <td>
                                                <form action="{{ route('admin.assistants.destroy', $assistant->id) }}" method="POST"> 
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

            <div class="pagination d-flex justify-content-center">{{ $assistants->links() }}</div>

            <!-- Modal -->
            @foreach($assistants as $assistant)
            <div class="modal fade" id="assistant{{ $assistant->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $assistant->system_id }}</h5>
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
                                                <td>{{ $assistant->name }}</td>
                                                <td><strong>Mobile :</strong></td>
                                                <td>{{ $assistant->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NID Number :</strong></td>
                                                <td>{{ $assistant->nid }}</td>
                                                <td><strong>Driving License :</strong></td>
                                                <td>{{ $assistant->driving_license }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Address :</strong></td>
                                                <td>{{ $assistant->address . ', ' . $assistant->city . ', ' . $assistant->postal_code }}</td>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $assistant->status }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    @if(! empty($assistant->driving_license_pic))
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Profile Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->profile_pic) }}">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">NID Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->nid_pic) }}">
                                    </div> 
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Driving License Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->driving_license_pic) }}">
                                    </div>
                                    @else
                                    <div class="col-md-6 text-center">
                                        <label class="form-label">Profile Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->profile_pic) }}">
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <label class="form-label">NID Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/assistant_picture/' . $assistant->nid . '/' . $assistant->nid_pic) }}">
                                    </div>
                                    @endif                          
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
                    if(confirm("Are you sure to delete this assistant?")) {
                        $(this).parent('form').submit()
                    }
                })
            }
        })
    </script>
@endsection
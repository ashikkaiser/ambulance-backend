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
                            <h3 class="card-title" style="flex-basis: 15%">DUser list</h3>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.users') }}" class="input-group align-items-center">
                                @csrf
                                <input type="text" name="search" class="form-control" placeholder="Search by user information"
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
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1}}</td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        @if($user->status == true)
                                        <td><span class="badge badge-warning mt-2" >{{ 'Pending' }}</span></td>
                                        @else
                                            <td><span class="badge badge-success mt-2" >{{ 'Active' }}</span></td>
                                        @endif
                                        <td><button class="btn btn-pill btn-success btn-sm" data-toggle="modal" data-target="{{ '#user' . $user->id }}">View</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!-- End Row -->

            
            <div class="pagination d-flex justify-content-center">{{ $users->links() }}</div>

            <!-- Modal -->
            @foreach($users as $user)
            <div class="modal fade" id="user{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $user->system_id }}</h5>
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
                                                <td>{{ $user->name }}</td>
                                                <td><strong>Mobile :</strong></td>
                                                <td>{{ $user->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email :</strong></td>
                                                <td>{{ $user->nid }}</td>
                                                <td><strong>NID :</strong></td>
                                                <td>{{ $user->driving_license }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{--
                                <div class="row mt-5">
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Profile Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/user_picture/' . $user->nid . '/' . $user->profile_pic) }}">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">NID Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/user_picture/' . $user->nid . '/' . $user->nid_pic) }}">
                                    </div> 
                                    <div class="col-md-4 text-center">
                                        <label class="form-label">Driving License Picture</label>
                                        <img class="profile_pic img-fluid h-100 border-radius-10px" 
                                        src="{{ asset('images/user_picture/' . $user->nid . '/' . $user->driving_license_pic) }}">
                                    </div>                               
                                </div>
                                --}}

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
{{-- Admin || Moderator --}}
<!-- End app-content-->
@endsection

@section('footer')
@include('footer')
@endsection
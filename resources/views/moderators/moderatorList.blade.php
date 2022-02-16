@extends('master')

@section('header')
    @include('header')
@endsection

@section('body')
{{-- Admin --}}
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', \App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">
            <!-- Row -->
            <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Moderator List</h3>
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
                                <table class="table table-striped card-table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Moderator ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($moderators as $moderator)
                                        <tr>
                                            <td>{{ ($moderators->currentPage()-1) * $moderators->perPage() + $loop->index + 1}}</td>
                                            <td>{{ $moderator->system_id }}</td>
                                            <td>{{ $moderator->name }}</td>
                                            <td>{{ $moderator->mobile }}</td>
                                            <td>{{ $moderator->email }}</td>
                                            <td>{{ $moderator->address . ', ' . $moderator->city . ', ' . $moderator->postal_code }}</td>
                                            @if($moderator->status == 'Active')
                                            <td><span class="badge badge-success mt-2">{{ $moderator->status }}</span></td>
                                            @else
                                            <td><span class="badge badge-warning mt-2">{{ $moderator->status }}</span></td>
                                            @endif
                                            <td><button class="btn btn-pill btn-success" data-toggle="modal" data-target="{{ '#moderator' . $moderator->id }}">View</button></td>
                                            <td><a href="{{ route('admin.moderators.edit', $moderator->id) }}" class="btn btn-pill btn-info">Modify</a></td>
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

            <div class="pagination d-flex justify-content-center">{{ $moderators->links() }}</div>

            <!-- Modal -->
            @foreach($moderators as $moderator)
            <div class="modal fade" id="moderator{{ $moderator->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $moderator->moderator_id }}</h5>
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
                                                <td>{{ $moderator->name }}</td>
                                                <td><strong>Email :</strong></td>
                                                <td>{{ $moderator->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile :</strong></td>
                                                <td>{{ $moderator->mobile }}</td>
                                                <td><strong>NID Number :</strong></td>
                                                <td>{{ $moderator->nid }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address :</strong></td>
                                                <td>{{ $moderator->address . ', ' . $moderator->city . ', ' . $moderator->postal_code }}</td>
                                                <td><strong>Status :</strong></td>
                                                <td>{{ $moderator->status }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6 text-center">
                                        <img class="profile_pic" src="{{ asset('images/moderator_picture/' . $moderator->nid . '/' . $moderator->profile_pic) }}"
                                        alt="" class="img-fluid">
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <img class="profile_pic" src="{{ asset('images/moderator_picture/' . $moderator->nid . '/' . $moderator->nid_pic) }}"
                                        alt="" class="img-fluid">
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
{{-- ! Admin  --}}
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
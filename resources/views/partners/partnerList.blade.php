@extends('master')

@section('header')
    @include('header')
@endsection

@section('body')
    {{-- Admin or Moderator --}}
    @if (Auth::guard('admin_user')->user()->can('haveAdminAccess', \App\Models\AdminUser::class) ||
        Auth::guard('admin_user')->user()->can('haveModeratorAccess', \App\Models\AdminUser::class))
        <div class="app-content main-content">
            <div class="side-app">
                <!-- Row -->
                <div class="row">
                    <div class="card">
                        <div class="card-header mb-4">
                            <div class="col-md-3">
                                <h3 class="card-title" style="flex-basis: 15%">Partner list</h3>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.partners.index') }}" class="input-group align-items-center">
                                    @csrf
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by partner information" value="">
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
                                <table class="table table-striped card-table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Partner ID</th>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Created By</th>
                                            <th>Verified By</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partners as $partner)
                                            <tr>
                                                <th>{{ ($partners->currentPage() - 1) * $partners->perPage() + $loop->index + 1 }}
                                                </th>
                                                <td>{{ $partner->system_id }}</td>
                                                <td>{{ $partner->category }}</td>
                                                <td>{{ $partner->name }}</td>
                                                <td>{{ $partner->mobile }}</td>
                                                <td>{{ $partner->email }}</td>
                                                <td>{{ $partner->created_by }}</td>
                                                <td>{{ $partner->verified_by }}</td>
                                                @if ($partner->status == 'Pending')
                                                    <td><span
                                                            class="badge badge-warning mt-2">{{ $partner->status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-success mt-2">{{ $partner->status }}</span>
                                                    </td>
                                                @endif
                                                <td><button class="btn btn-pill btn-success" data-toggle="modal"
                                                        data-target="{{ '#partner' . $partner->id }}">View</button></td>
                                                <td><a href="{{ route('admin.partners.edit', $partner->id) }}"
                                                        class="btn btn-pill btn-info">Modify</a></td>
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

            <div class="pagination d-flex justify-content-center">{{ $partners->links() }}</div>

            <!-- Modal -->
            @foreach ($partners as $partner)
                <div class="modal fade" id="partner{{ $partner->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $partner->system_id }}</h5>
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
                                                    <td>{{ $partner->name }}</td>
                                                    <td><strong>Email :</strong></td>
                                                    <td>{{ $partner->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Mobile :</strong></td>
                                                    <td>{{ $partner->mobile }}</td>
                                                    <td><strong>NID Number :</strong></td>
                                                    <td>{{ $partner->nid }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category :</strong></td>
                                                    <td>{{ $partner->category }}</td>
                                                    <td><strong>Company Name :</strong></td>
                                                    <td>{{ $partner->company }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Address :</strong></td>
                                                    <td>{{ $partner->address . ', ' . $partner->city . ', ' . $partner->postal_code }}
                                                    </td>
                                                    <td><strong>Status :</strong></td>
                                                    <td>{{ $partner->status }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created By :</strong></td>
                                                    <td>{{ $partner->created_by }}</td>
                                                    <td><strong>Verified By :</strong></td>
                                                    <td>{{ $partner->verified_by }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    @if (empty($partner->trade_license_picture))
                                        <div class="row mt-5">
                                            <div class="col-md-6 text-center">
                                                <label class="form-label">Profile Picture</label>
                                                <img class="profile_pic"
                                                    src="{{ asset('images/partner_picture/' . $partner->nid . '/' . $partner->profile_picture) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <label class="form-label">NID Picture</label>
                                                <img class="profile_pic"
                                                    src="{{ asset('images/partner_picture/' . $partner->nid . '/' . $partner->nid_picture) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mt-5">
                                            <div class="col-md-4 text-center">
                                                <label class="form-label">Profile Picture</label>
                                                <img class="profile_pic"
                                                    src="{{ asset('images/partner_picture/' . $partner->nid . '/' . $partner->profile_picture) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label class="form-label">NID Picture</label>
                                                <img class="profile_pic"
                                                    src="{{ asset('images/partner_picture/' . $partner->nid . '/' . $partner->nid_picture) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label class="form-label">Trade License Picture</label>
                                                <img class="profile_pic"
                                                    src="{{ asset('images/partner_picture/' . $partner->nid . '/' . $partner->trade_license_picture) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    @endif
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

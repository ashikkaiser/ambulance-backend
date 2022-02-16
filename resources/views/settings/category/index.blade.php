@extends('master')

@section('header')
    @include('header')
@endsection

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .extrabtn {
        display: flex;
        align-items: center
    }

</style>

@section('body')
    {{-- Admin Section --}}

    @php
    use App\Models\VehiclesCategory;
    function getSubs($id)
    {
        return VehiclesCategory::where('parent_id', $id)->get();
    }
    @endphp
    <div class="app-content main-content ">
        <div class="side-app ">

            {{-- <div class="row"> --}}
            {{-- <div class="col-xl-2 col-lg-2 col-md-2">
                </div> --}}
            <div class="col-xl-10 col-lg-10 col-md-12 ">
                <form action="{{ route('admin.categories') }}" method="POST">
                    @csrf
                    <div class="card" id="left-card">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 ">

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-label">Category Name <span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Name" autofocus
                                                value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror" autocomplete="name"
                                                required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-3">
                                            <label class="form-label">Sub Category <span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control custom-select select2 child-select" name="isChild"
                                                required>
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>

                                        </div>

                                    </div>
                                    <div class="form-group row parent-form">
                                        <div class="col-md-3">
                                            <label class="form-label">Parent Category <span
                                                    class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control custom-select select2 parant-select"
                                                name="parent_id">
                                                @foreach ($parants as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row govt_fair_form">
                                        <div class="col-md-3">
                                            <label class="form-label">Govt fair /km<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="govt_fair" placeholder="Fair per Km" autofocus
                                                value="{{ old('govt_fair') }}"
                                                class="form-control @error('govt_fair') is-invalid @enderror">
                                            @error('govt_fair')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group row local_fair_form">
                                        <div class="col-md-3">
                                            <label class="form-label">Local fair /km<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="local_fair" placeholder="Local Fair per Km" autofocus
                                                value="{{ old('local_fair') }}"
                                                class="form-control @error('local_fair') is-invalid @enderror">
                                            @error('local_fair')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group row city_fair_form">
                                        <div class="col-md-3">
                                            <label class="form-label">City fair /km<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group field_wrapper">
                                                <div class="form-group row">
                                                    <div class="col-md-11 input-group ">
                                                        <input type="number" class="form-control" placeholder="KM"
                                                            name="km[]">
                                                        <input type="number" class="form-control" placeholder="Fair"
                                                            name="fair[]">
                                                        <input type="number" class="form-control" placeholder="Booth"
                                                            name="booth[]">

                                                    </div>
                                                    <a href="javascript:void(0);" class="add_button col-sm-1 extrabtn"
                                                        title="Add field"><i class="fa fa-plus"></i></a>


                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="form-group row waiting_charge_form">
                                        <div class="col-md-3">
                                            <label class="form-label">Waiting Charge<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="waiting_charge" placeholder="Waiting Charge per KM"
                                                autofocus value="{{ old('waiting_charge') }}"
                                                class="form-control @error('waiting_charge') is-invalid @enderror">
                                            @error('waiting_charge')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group row extra_charge_form">
                                        <div class="col-md-3">
                                            <label class="form-label">Extra Charge<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="extra_charge" placeholder="Ex Charge per Trip"
                                                autofocus value="{{ old('extra_charge') }}"
                                                class="form-control @error('extra_charge') is-invalid @enderror">
                                            @error('extra_charge')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row extra_charge_form">
                                        <div class="col-md-3">
                                            <label class="form-label">Discount Percent<span
                                                    class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="discount_percent" placeholder="Discount Percent"
                                                autofocus value="{{ old('discount_percent') }}"
                                                class="form-control @error('discount_percent') is-invalid @enderror">
                                            @error('discount_percent')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 d-flex w-100">
                                    <div class="btn-list mx-auto">
                                        <button type="submit" name="addCategory"
                                            class="btn btn-pill btn-success px-5">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-xl-3 col-lg-3 col-md-3">
                </div> --}}
            {{-- </div> --}}
            <div class="row"></div>
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card" id="left-card">
                    <div class="card-header">
                        <h3 class="card-title">Category List</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped card-table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Govt Fair</th>
                                            <th>Local Fair</th>
                                            <th>Waiting Charge</th>
                                            <th>City Fair</th>
                                            <th>Booth Charge</th>
                                            <th>Discount Percent</th>
                                            <th>Modify</th>
                                            <th>Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($parants as $key => $item)
                                            <tr>
                                                <th scope="row"><strong>{{ $key + 1 }}</strong></th>
                                                <td><strong>{{ $item->name }}</strong></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href="{{ route('admin.categories.edit', $item->id) }}"
                                                        class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                                <td>
                                                    <form action="{{ route('admin.categories.destroy', $item->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button
                                                            class="btn btn-pill btn-danger btn-sm delete-btn">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @foreach (getSubs($item->id) as $subcategory)
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>{{ $subcategory->name }}</td>
                                                    <td>&#2547; {{ $subcategory->govt_fair }} /Km</td>
                                                    <td>&#2547; {{ $subcategory->local_fair }} /Km</td>
                                                    <td>&#2547; {{ $subcategory->waiting_charge }} /Km</td>
                                                    <td>
                                                        <table>
                                                            <thead>
                                                                <th>KM</th>
                                                                <th>Fair</th>
                                                                <th>Booth</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($subcategory->city_fair as $c_fair)
                                                                    <tr>
                                                                        <th>{{ $c_fair['km'] }} Km</th>
                                                                        <th>{{ $c_fair['fair'] }} Tk</th>
                                                                        <th>{{ $c_fair['booth'] }} Tk</th>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>

                                                        </table>

                                                    </td>
                                                    <td>{{ $subcategory->fixed_charge}} Tk</td>
                                                    <td>{{ $subcategory->discount_percent . ' %' }}</td>
                                                    
                                                    <td><a href="{{ route('admin.categories.edit', $subcategory->id) }}"
                                                            class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                                    <td>
                                                        <form
                                                            action="{{ route('admin.categories.destroy', $subcategory->id) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                class="btn btn-pill btn-danger btn-sm delete-btn">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    {{-- ! Admin Section --}}
@endsection

@section('footer')
    @include('footer')
    <script>
        $(document).ready(function() {
            $('.govt_fair_form').hide();
            $('.extra_charge_form').hide();
            $('.local_fair_form').hide();
            $('.city_fair_form').hide();
            $('.waiting_charge_form').hide();
            $('.parent-form').hide();
            $('.child-select').on('change', function() {
                if ($(this).val() == 'yes') {
                    $('.parent-form').show()
                    $('.govt_fair_form').show();
                    $('.extra_charge_form').show();
                    $('.local_fair_form').show();
                    $('.waiting_charge_form').show();
                    $('.city_fair_form').show()
                } else {
                    $('.parent-form').hide()
                    $('.parent-form').hide()
                    $('.govt_fair_form').hide();
                    $('.city_fair_form').hide()
                    $('.extra_charge_form').hide();
                    $('.local_fair_form').hide();
                    $('.waiting_charge_form').hide();
                }

            })
        })
        deleteBtn()

        function deleteBtn() {
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault()
                if (confirm("Are you sure to delete this category?")) {
                    $(this).parent('form').submit()
                }
            })
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 5;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var variable = '' +
                '        <div class="form-group row">' +
                '            <div class="col-md-11 input-group">' +
                '                <input type="number" class="form-control" placeholder="Km" name="km[]">' +
                '                <input type="number" class="form-control" placeholder="Fair" name="fair[]">' +
                '                <input type="number" class="form-control" placeholder="Booth" name="booth[]">' +
                '            </div>' +
                '                <a href="javascript:void(0);" class="remove_button col-sm-1 extrabtn" title="Add field"><i class="fa fa-minus"></i></a>' +
                '        </div>' +
                '';
            var x = 1;
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper).append(variable);
                }
            });
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            });
        });
    </script>
@endsection

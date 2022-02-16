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
    @if (Auth::guard('admin_user')->user()->can('haveAdminAccess', \App\Models\AdminUser::class))
        <div class="app-content main-content">
            <div class="side-app">
                <div class="app-content main-content ">
                    <div class="side-app">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                            @csrf
                            {{-- @method('post') --}}
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-12">
                                    <div class="card" id="left-card">
                                        <div class="card-header">
                                            <h3 class="card-title">Edit Category</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 ">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Name <span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="name" placeholder="Name" autofocus
                                                                value="{{ $category->name }}"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                autocomplete="name" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="form-group row parent-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Is Child <span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control custom-select select2 child-select"
                                                                id="is_child" name="isChild" required>
                                                                <option value="no">No</option>
                                                                <option value="yes" @if ($category->parent_id !== 0) {{ 'selected' }} @endif>Yes
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row parent-form hide-element" id="parent_id">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Parent Category <span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control custom-select select2 parant-select"
                                                                name="parent_id">
                                                                @foreach ($parents as $item)
                                                                    <option value="{{ $item->id }}" @if ($item->id == $category->parent_id) {{ 'selected' }} @endif>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row govt_fair_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Govt fair /km<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="govt_fair" placeholder="Fair per Km"
                                                                autofocus value="{{ $category->govt_fair }}"
                                                                class="form-control @error('name') is-invalid @enderror">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="form-group row local_fair_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Local fair /km<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="local_fair"
                                                                placeholder="Local Fair per Km" autofocus
                                                                value="{{ $category->local_fair }}"
                                                                class="form-control @error('local_fair') is-invalid @enderror">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="form-group row city_fair_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">City fair /km + Booth<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group field_wrapper">
                                                                @foreach ($category->city_fair as $key => $item)
                                                                    <div class="form-group row">
                                                                        <div class="col-md-11 input-group ">
                                                                            <input type="number" class="form-control"
                                                                                placeholder="KM" name="km[]"
                                                                                value="{{ $item['km'] }}">
                                                                            <input type="number" class="form-control"
                                                                                placeholder="Fair" name="fair[]"
                                                                                value="{{ $item['fair'] }}">
                                                                            <input type="number" class="form-control"
                                                                                placeholder="Booth" name="booth[]">

                                                                        </div>
                                                                        @if ($key === 0)
                                                                            <a href="javascript:void(0);"
                                                                                class="add_button col-sm-1 extrabtn"
                                                                                title="Add field"><i
                                                                                    class="fa fa-plus"></i></a>
                                                                        @else
                                                                            <a href="javascript:void(0);"
                                                                                class="remove_button col-sm-1 extrabtn"
                                                                                title="Add field"><i
                                                                                    class="fa fa-minus"></i></a>
                                                                        @endif

                                                                    </div>
                                                                @endforeach

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="form-group row extra_charge_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Fixed Charge<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="fixed_charge"
                                                                placeholder="Booth Charge" autofocus
                                                                value="{{ $category->fixed_charge }}"
                                                                class="form-control @error('fixed_charge') is-invalid @enderror">
                                                            @error('fixed_charge')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row waiting_charge_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Waiting Charge<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="waiting_charge"
                                                                placeholder="Waiting Charge per KM" autofocus
                                                                value="{{ $category->waiting_charge }}"
                                                                class="form-control @error('waiting_charge') is-invalid @enderror">
                                                            @error('waiting_charge')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="form-group row extra_charge_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Extra Charge<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="extra_charge"
                                                                placeholder="Ex Charge per Trip" autofocus
                                                                value="{{ $category->extra_charge }}"
                                                                class="form-control @error('extra_charge') is-invalid @enderror">
                                                            @error('extra_charge')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row extra_charge_form hide-element">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Discount Percent<span
                                                                    class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="discount_percent"
                                                                placeholder="Discount Percent" autofocus
                                                                value="{{ $category->discount_percent }}"
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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif
    {{-- ! Admin Section --}}
@endsection

@section('footer')
    @include('footer')
    <script src="/vendors/clone/jquery-cloneya.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $('.child-select').val() == 'no' ? $('.hide-element').hide() : $('.hide-element').show()


            $('.child-select').on('change', function() {
                $(this).val() == 'no' ? $(this).parents('.parent-element').siblings('.hide-element')
                    .hide() :
                    $(this).parents('.parent-element').siblings('.hide-element').show()
            })

            setTimeout(function() {
                $('.timeout').hide();
            }, 5000);
        })
    </script>
@endsection

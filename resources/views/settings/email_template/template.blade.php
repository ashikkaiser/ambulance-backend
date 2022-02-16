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
</style>

@section('body')
{{-- Admin Section --}}

    <div class="app-content main-content ">
        <div class="side-app">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <form action="" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add Email Template</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 ">
                                        
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <input type="text" name="name" placeholder="Name" autofocus
                                                    value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    autocomplete="name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" name="subject" placeholder="Subject" autofocus
                                                    value="{{ old('subject') }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    autocomplete="subject" required>
                                                @error('subject')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea type="text" name="body" placeholder="Body" row="8" 
                                                    class="form-control @error('body') is-invalid @enderror"
                                                    autocomplete="body"></textarea>
                                                @error('body')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex w-100">
                                        <div class="btn-list mx-auto">
                                            <button type="submit" name="addemail"
                                                class="btn btn-pill btn-success px-5">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row"></div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card" id="left-card">
                        <div class="card-header">
                            <h3 class="card-title">Template List</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped card-table table-vcenter">
                                        <thead class="w-100">
                                            <tr>
                                                <th style="width: 5% !important">SL</th>
                                                <th style="width: 10% !important">Name</th>
                                                <th style="width: 20% !important">Subject</th>
                                                <th style="width: 55% !important">Body</th>                                  
                                                <th style="width: 5% !important">Modify</th>
                                                <th style="width: 5% !important">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>{{ __('New Email') }}</td>
                                                <td>{{ __('New Email Subject') }}</td>
                                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi rerum omnis dolorum, similique maxime atque dolores necessitatibus sed, natus nesciunt esse blanditiis enim impedit eaque amet voluptatibus unde, cum quo?</td>
                                                <td><a href=""
                                                    class="btn btn-pill btn-info btn-sm">Modify</a></td>
                                                <td>
                                                    <form
                                                        action=""
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button
                                                            class="btn btn-pill btn-danger btn-sm delete-btn mt-4">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
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
            $('.waiting_charge_form').hide();
            $('.parent-form').hide();
            $('.child-select').on('change', function() {
                if ($(this).val() == 'yes') {
                    $('.parent-form').show()
                    $('.govt_fair_form').show();
                    $('.extra_charge_form').show();
                    $('.local_fair_form').show();
                    $('.waiting_charge_form').show();
                } else {
                    $('.parent-form').hide()
                    $('.parent-form').hide()
                    $('.govt_fair_form').hide();
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

@endsection

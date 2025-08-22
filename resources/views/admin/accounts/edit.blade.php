@php use App\Models\Countries; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Account Title</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter bank information</h5>
                            <form action="{{ route('admin.accounts.update', $data->id) }}" method="POST">
                            @csrf
                                @method('PUT')
                            <div class="mb-4">
                                <label for="account_name" class="form-label">Account Title</label>
                                <input type="text" placeholder="" class="form-control" id="account_name" name="account_name"  value="{{ old('account_name') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="account_type" class="form-label">Account Type</label>
                                <select class="form-select" id="account_type" name="account_type" required >
                                    <option value="">Select</option>
                                    <option value="Account">Account</option>
                                    <option value="Expense">Expense</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Provider">Provider</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded" type="submit" name="submit">SUBMIT</button>
                            </div>





                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

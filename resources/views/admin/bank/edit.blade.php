@php use App\Models\Countries; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $data->bank_name }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter bank information</h5>
                        <form action="{{ route('admin.bank.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="bank_account_title" class="form-label">Bank Account Title</label>
                                <input type="text" placeholder="" class="form-control" id="bank_account_title" name="bank_account_title"  value="{{ $data->bank_account_title }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="bank_account_no" class="form-label">Bank Account No.</label>
                                <input type="text" placeholder="" class="form-control" id="bank_account_no" name="bank_account_no"  value="{{ $data->bank_account_no }}">
                            </div>
                            <div class="mb-4">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" placeholder="" class="form-control" id="bank_name" name="bank_name"  value="{{ $data->bank_name }}">
                            </div>
                            <div class="mb-4">
                                <label for="bank_branch" class="form-label">Branch Name</label>
                                <input type="text" placeholder="" class="form-control" id="bank_branch" name="bank_branch"  value="{{ $data->bank_branch }}">
                            </div>

                            <div class="mb-4">
                                <label for="bank_country" class="form-label">Country Name</label>
                                <select class="form-select" id="bank_country" name="bank_country"  >
                                    <option value="">Select</option>
                                    @foreach(Countries::orderBy('country_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                        <option value="{{ $p->country_name }}" {{ $p->country_name == $data->bank_country ? 'selected' : '' }}  >{{ $p->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="bank_currency" class="form-label">Currency</label>
                                <select class="form-select" id="bank_currency" name="bank_currency" required >
                                    <option value="">Select</option>
                                    <option value="USD" {{ 'USD' == $data->bank_currency ? 'selected' : '' }} >USD</option>
                                    <option value="JPY" {{ 'JPY' == $data->bank_currency ? 'selected' : '' }} >JPY</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="bank_details" class="form-label">Bank Details/Descriptions/Comments</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="bank_details" name="bank_details">{{$data->bank_details}}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded" type="submit" name="submit">UPDATE</button>
                            </div>





                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

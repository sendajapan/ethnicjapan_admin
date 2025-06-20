@php use App\Models\Countries; @endphp
@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $data->customer_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter customer information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customer.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')



                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_name" class="form-label">Customer Name</label>
                                    <input type="text" placeholder="ex. GRAINS" class="form-control" id="customer_name" name="customer_name" value="{{ $data->customer_name }}" required>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_primary_contact_name" class="form-label">Primary Contact Name</label>
                                    <input type="text" placeholder="ex. Phone Number" class="form-control" id="customer_primary_contact_name" name="customer_primary_contact_name" value="{{ $data->customer_primary_contact_name }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_primary_contact_email" class="form-label">Primary Contact Email</label>
                                    <input type="text" placeholder="ex. Email Address" class="form-control" id="customer_primary_contact_email" name="customer_primary_contact_email" value="{{ $data->customer_primary_contact_email }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_office_phone" class="form-label">Office Phone Number</label>
                                    <input type="text" placeholder="ex. Phone Number" class="form-control" id="customer_office_phone" name="customer_office_phone" value="{{ $data->customer_office_phone }}">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_country_name" class="form-label">Country Name</label>
                                    <select class="form-select" id="customer_country_name" name="customer_country_name"  >
                                        <option value="">Select</option>
                                        @foreach(Countries::orderBy('country_name')->get() as $p)
                                            <option {{ $p->country_name == $data->customer_country_name ? 'selected' : '' }} value="{{ $p->country_name }}"  >{{ $p->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_description" class="form-label">Customer Description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="customer_description" name="customer_description">{{ $data->customer_description }}</textarea>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="customer_address" class="form-label">Customer Address</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="customer_address" name="customer_address">{{ $data->customer_address }}</textarea>
                                </div>
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

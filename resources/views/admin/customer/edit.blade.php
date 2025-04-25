@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $data->customer_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter customer information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customer.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <input type="text" placeholder="ex. GRAINS" class="form-control" id="customer_name" name="customer_name" value="{{ $data->customer_name }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="customer_description" class="form-label">Customer Description</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="customer_description" name="customer_description">{{ $data->customer_description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="customer_address" class="form-label">Customer Address</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="customer_address" name="customer_address">{{ $data->customer_address }}</textarea>
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

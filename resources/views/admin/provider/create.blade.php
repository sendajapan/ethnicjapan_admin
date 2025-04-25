@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Provider</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter provider information</h5>
                        <form action="{{ route('admin.provider.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="provider_name" class="form-label">Provider Name</label>
                                <input type="text" placeholder="ex. Company Name" class="form-control" id="provider_name" name="provider_name"  value="{{ old('provider_name') }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="provider_description" class="form-label">Provider Description</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="provider_description" name="provider_description"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="provider_address" class="form-label">Provider Address</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="provider_address" name="provider_address"></textarea>
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

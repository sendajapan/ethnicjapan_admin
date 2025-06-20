@php use App\Models\Countries; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Port</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter bank information</h5>
                        <form action="{{ route('admin.ports.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="port_name" class="form-label">Port Name</label>
                                <input type="text" placeholder="" class="form-control" id="port_name" name="port_name"  value="{{ old('port_name') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="account_type" class="form-label">Country Name</label>
                                <select class="form-select" id="country_name" name="country_name" required >
                                    <option value="">Select</option>
                                    @foreach(Countries::orderBy('country_name')->get() as $p)
                                        <option value="{{ $p->country_name }}"  >{{ $p->country_name }}</option>
                                    @endforeach
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

@php use App\Enums\Currency; @endphp
@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Create Cost</h4>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-6 col-xxl-5">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Cost Type Data</h5>
                        <form action="{{ route('admin.cost.store') }}" method="POST">
                            @csrf
                            <div class="card mb-2 border-0">
                                <div class="card-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cost_type" name="cost_type"
                                               value="{{ old('cost_type') }}" placeholder="Enter Cost Type" required>
                                        <label for="phone">Cost Type</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="currency" name="currency" required>
                                            <option selected disabled>Select Currency</option>
                                            @foreach(Currency::cases() as $currency)
                                                <option value="{{ $currency->value }}" {{ $currency->value === 'tala' ? 'selected' : '' }}>{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="currency">Currency</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="default_cost" name="default_cost"
                                               value="{{ old('default_cost') }}" placeholder="Default Cost" required>
                                        <label for="phone">Default Cost</label>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="active" name="active" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <label for="active">Status</label>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center">
                                <button type="submit" class="btn btn-primary">Create Cost</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

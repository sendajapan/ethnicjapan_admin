@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $partName->name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter category information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.part-category.update', $partName->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" placeholder="ex. ABS ACTUATOR" class="form-control" id="category_name" name="category_name" value="{{ $partName->name }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="category_description" class="form-label">Full Description (Optional)</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="category_description" name="category_description"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Default Price</label>
                                        <div class="row gx-2">
                                            <input placeholder="¥" type="text" class="form-control" name="default_price" value="{{ number_format($partName->price) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Default Quantity</label>
                                        <input type="number" class="form-control" name="default_quantity" value="{{ $partName->quantity }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Generic</label>
                                    <select class="form-select" name="generic">
                                        <option value="0" {{ $partName->is_generic === 0 ? 'selected' : '' }} >No</option>
                                        <option value="1" {{ $partName->is_generic === 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
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

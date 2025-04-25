@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Category</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter category information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.part-category.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" placeholder="ex. ABS ACTUATOR" class="form-control" id="category_name" name="category_name" required>
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
                                            <input placeholder="$" type="text" class="form-control" name="default_price" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Default Quantity</label>
                                        <input type="number" class="form-control" name="default_quantity" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Generic</label>
                                    <select class="form-select" name="generic">
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
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

@php use App\Models\PartCategory; @endphp
@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Sub-Category</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xxl-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Please enter sub-category information</h5>
                        <form action="{{ route('admin.part-sub-category.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="category" class="form-label">Category Name</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option selected disabled>Please select a category</option>
                                    @foreach(PartCategory::orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="sub_category" class="form-label">Sub-Category Name</label>
                                <input type="text" placeholder="ex. Spark plugs" class="form-control" id="sub_category" name="sub_category" value="{{ old('sub_category') }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="category_description" class="form-label">Full Description (Optional)</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="category_description" name="category_description"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Default Price</label>
                                        <div class="row gx-2">
                                            <input placeholder="$" type="number" class="form-control text-end fw-bold" name="default_price" value="{{ old('default_price') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Default Quantity</label>
                                        <input type="number" class="form-control text-end fw-bold" name="default_quantity" value="{{ old('default_quantity') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded" type="submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

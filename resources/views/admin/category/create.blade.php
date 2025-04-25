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
                    <div class="card-body">
                        <h5>Please enter category information</h5>
                        <form action="{{ route('admin.category.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" placeholder="ex. GRAINS" class="form-control" id="category_name" name="category_name"  value="{{ old('category_name') }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="category_description" class="form-label">Category Description</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="category_description" name="category_description"></textarea>
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

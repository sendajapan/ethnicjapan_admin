@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Update {{ $data->item_name }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Please enter item information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.item.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="item_name" class="form-label">Item Name</label>
                                <input type="text" placeholder="ex. Item Name" class="form-control" id="item_name" name="item_name" value="{{ $data->item_name }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="item_description" class="form-label">Item Description</label>
                                <textarea placeholder="Type here" class="form-control" rows="4" id="item_description" name="item_description">{{ $data->item_description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="hts_code" class="form-label">HTS Code</label>
                                <input type="text" placeholder="ex. 1800.00.00" class="form-control" id="hts_code" name="hts_code"  value="{{ $data->hts_code }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="hts_code" class="form-label">Default Price</label>
                                <input type="text" placeholder="ex. 9.95" class="form-control" id="default_price" name="default_price"  value="{{ $data->default_price }}" required>
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

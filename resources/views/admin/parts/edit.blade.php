@extends('admin.layouts.master')

@section('content')

    @php
        $vehicleId = -1;
        if(count($parts) > 0){
            $vehicleId = $parts->first()->vehicle->id;
        }
    @endphp

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Edit Part</h4>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-xl-12">
                    <div class="card px-0">
                        <header class="card-header">
                            <div class="card mb-4">
                                <div class="card-header bg-brand-1" style="height: 150px"></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl col-lg flex-grow-0" style="flex-basis: 230px">
                                            <div class="img-thumbnail shadow-sm w-100 bg-white position-relative text-center" style="height: 190px; width: 200px; margin-top: -120px">
                                                <img src="{{ $brandLogo }}" class="center-xy img-thumbnail" alt="Logo Brand">
                                            </div>
                                        </div>
                                        <div class="col-xl col-lg">
                                            <h3>{{ $parts->first()->vehicle->make_title }}</h3>
                                            <p>{{ $parts->first()->vehicle->model_title }}</p>
                                        </div>
                                        <div class="col-xl col-lg text-md-end">
                                            <a href="{{ route('admin.shipment.index', $parts->first()->vehicle->shipment->id) }}" class="btn btn-primary">View Shipment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-parts" style="table-layout: auto">
                                        <thead class="bg-primary-subtle text-uppercase table-light">
                                        <tr class="border-1">
                                            <th class="text-center">S/N</th>
                                            <th>Part Name</th>
                                            <th>Barcode</th>
                                            <th class="d-flex gap-4 justify-content-center">
                                                <span>Quantity</span>
                                                <span>Price</span>
                                            </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($parts as $part)
                                            <tr class="border-1">
                                                <td class="text-center border-1 p-0" width="40">{{ $part->partCategory->id }}</td>
                                                <td class="border-1 fw-bold" style="font-size: 11px">{{ $part->partCategory->name }}</td>
                                                <td class="border-1 text-center p-0">
                                                    @php
                                                        echo DNS1D::getBarcodeHTML(sprintf('%03d', $part->vehicle->id). sprintf('%03d', $part->id) , 'C39', 2, 34, 'black', false);
                                                    @endphp
                                                </td>
                                                <td class="p-0">
                                                    <form action="{{ route('admin.part.update', $part->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="d-flex gap-4 justify-content-center">
                                                            <input class="form-control text-end" type="text" name="quantity" value="{{ $part->quantity }}" style="width: 80px !important; height: 28px"/>
                                                            <input class="form-control text-end" type="text" name="price" value="{{ $part->price }}" style="width: 100px !important; height: 28px"/>
                                                            <button class="btn btn-xs text-center bg-dark fw-bold text-uppercase" type="submit">Update</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-center border-1 p-0">
                                                    <a href="#" class="text-success add-to-cart" data-id="{{ $part->partCategory->id }}" data-name="{{ $part->partCategory->name }}" data-quantity="{{ $part->quantity }}" data-price="{{ $part->price }}">Add to cart</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer hidden">
                            <a href="{{ route('admin.part.print', $vehicleId) }}" class="btn btn-primary" target="_blank"><i class="text-muted my-auto material-icons md-barcode"></i>PRINT BARCODE</a>
                        </div>
                    </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        const cartStoreUrl = '{{ route('admin.cart.store') }}';
        const csrfToken = '{{ csrf_token() }}';
    </script>
    <script defer src="{{ asset('assets/js/cart.js') }}"></script>
@endpush


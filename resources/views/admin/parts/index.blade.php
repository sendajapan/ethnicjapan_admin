@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Parts Categories</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-5">
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title">Total Vehicles</h6>
                            <a href="{{ route('admin.part-category.create') }}" class="btn btn-primary btn-sm rounded">Create New</a>
                        </div>
                    </header>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap mb-0" style="table-layout: auto">
                                    <thead class="table-light border-1">
                                    <tr>
                                        <th class="align-middle" scope="col" width="40">S/N</th>
                                        <th class="align-middle" scope="col">Part Name</th>
                                        <th class="align-middle text-center" scope="col">Quantity</th>
                                        <th class="align-middle text-end" scope="col">Price</th>
                                        <th class="align-middle" scope="col">Generic</th>
                                        <th class="align-middle text-center" scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(!empty($partNames))
                                        @foreach($partNames as $partName)
                                            <tr>
                                                <td class="border-1 text-center"><a href="#" class="fw-bold">#{{$partName->id}}</a></td>
                                                <td class="border-1">{{$partName->name}}</td>
                                                <td class="text-center border-1">{{$partName->quantity}}</td>
                                                <td class="text-end border-1">{{$partName->price}}</td>
                                                <td class="border-1 text-center">{{$partName->is_generic ? 'yes' : 'no'}}</td>
                                                <td class="border-1 px-0">
                                                    <div class="d-flex justify-content-evenly text-end">
                                                        <a href="{{ route('admin.part-category.edit') }}" class="btn btn-sm font-sm rounded btn-brand"> <i class="material-icons md-edit"></i></a>
                                                        <a href="#" class="btn btn-sm font-sm btn-light rounded"> <i class="material-icons md-delete_forever"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td class="text-danger" colspan="5">No Data</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

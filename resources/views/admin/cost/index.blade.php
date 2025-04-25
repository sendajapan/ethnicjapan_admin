@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Costs List</h4>
        </div>

        <div class="row">
            <div class="col-xl-8 col-xxl-6">
                <div class="card mb-2">
                    <div class="card-body">
                        <div style="display: flex; justify-content: end">
                            <a href="{{ route('admin.cost.create') }}" class="btn btn-sm btn-outline-dark text-sm mb-4"><i class="fas fa-plus"></i>New Cost</a>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle table-nowrap mb-0" style="white-space: none">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="text-center" scope="col">S/N</th>
                                        <th class="text-start" scope="col">Cost Type</th>
                                        <th class="text-end" scope="col">Default Cost</th>
                                        <th class="text-center" scope="col">Currency</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Created At</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$costs->isEmpty())
                                        @foreach($costs as $cost)
                                            <tr>
                                                <td width="50" class="text-center">
                                                    <a href="#" class="fw-bold text-black">#{{ $cost->id }}</a>
                                                </td>
                                                <td class="text-start fw-bold"><strong>{{ $cost->name }}</strong></td>
                                                <td class="text-end fw-bold">{{ number_format($cost->default_cost, 0) }}</td>
                                                <td class="text-center">{{ strtoupper($cost->currency) }}</td>
                                                <td class="text-center"><span class="badge badge-pill {{ $cost->active === 1 ? 'badge-soft-success text-success' : 'badge-soft-danger text-danger' }} text-uppercase fw-bold">{{ $cost->active === 1 ? 'Active' : 'Inactive' }}</span></td>
                                                <td class="text-center">{{ $cost->created_at }}</td>
                                                <td class="text-center">
                                                    <div style="display: flex; justify-content: center">
                                                        <a href="{{ route('admin.cost.edit', $cost->id) }}"><i class="icon material-icons md-edit text-black px-1 fs-5"></i></a>
                                                        <a href="#"><i class="icon material-icons md-delete_outline text-danger px-1 fs-5"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center text-danger" colspan="7">no cost type found!!!</td>
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

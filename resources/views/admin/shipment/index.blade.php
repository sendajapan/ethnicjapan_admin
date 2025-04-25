@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Shipments</h4>
        </div>

        <div class="row">
            <div class="col-xxl-10 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

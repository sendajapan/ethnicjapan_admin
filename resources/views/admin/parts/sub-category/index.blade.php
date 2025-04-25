@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Part Sub-Categories</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-8 col-xxl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('admin.part-sub-category.create') }}" class="btn btn-sm btn-outline-dark text-sm mb-4"><i class="fas fa-plus"></i>New Sub-Category</a>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap table-part-category mb-0" style="table-layout: auto">
                                    <thead class="table-light border-1">
                                    <tr>
                                        <th class="text-center" scope="col" width="60">S/N</th>
                                        <th scope="col">Sub-Part Name</th>
                                        <th scope="col">Part Name</th>
                                        <th class="text-center" scope="col">Quantity</th>
                                        <th class="text-end" scope="col">Price</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($partSubCategories) > 0)
                                        @foreach($partSubCategories as $partSubCategory)
                                            <tr>
                                                <td class="border-1 fw-bolder text-primary-emphasis text-center">{{ $loop->iteration }}</td>
                                                <td class="border-1 fw-bold px-4" style="font-size: 11px">{{ strtoupper($partSubCategory->name) }}</td>
                                                <td class="border-1 fw-bold px-4" style="font-size: 11px">{{ strtoupper($partSubCategory->partCategory->name) }}</td>
                                                <td class="text-center border-1">{{$partSubCategory->quantity}}</td>
                                                <td class="text-end border-1 fw-bolder text-primary-emphasis">${{ number_format($partSubCategory->price, 2) }}</td>
                                                <td class="border-1 text-center">{{$partSubCategory->is_generic ? 'yes' : 'no'}}</td>
                                                <td width="120" class="border-1 px-0">
                                                    <div class="d-flex justify-content-evenly text-end">
                                                        <a href="{{ route('admin.part-category.edit', $partSubCategory->id) }}" class="btn btn-sm font-sm rounded btn-dark">
                                                            <i class="material-icons md-edit fs-6"></i>
                                                        </a>
                                                        <a href="{{ route('admin.part-category.destroy', $partSubCategory->id) }}" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                            <i class="material-icons md-delete_forever fs-6"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td class="text-danger" colspan="6">no data found!!!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')

    <script>
        function performDeleteRequest(url) {
            $.ajax({
                type: 'DELETE',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: handleDeleteSuccess,
                error: handleDeleteError
            });
        }

        function confirmDelete(url) {
            Swal.fire({
                title: "Are you sure you want to delete this part?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    performDeleteRequest(url);
                }
            });
        }

        $(document).ready(function () {
            $('body').on('click', '.delete-part-category', function (event) {
                event.preventDefault();
                confirmDelete($(this).attr('href'));
            });
        });
    </script>

@endpush

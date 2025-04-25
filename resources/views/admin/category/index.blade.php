@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Categories</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12 col-xxl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-outline-dark text-sm mb-4"><i class="fas fa-plus"></i>New Category</a>
                        </div>
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

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

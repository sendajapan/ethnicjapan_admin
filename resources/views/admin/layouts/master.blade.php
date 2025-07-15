<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ETHNIC LTD. Admin Panel</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}"/>
    <!-- Template CSS -->
    <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>
    <link href="{{ asset('assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/datatables.bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    {{-- Font Awesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<div class="screen-overlay"></div>

@include('admin.layouts.sidebar')

<main class="main-wrap">

{{--    <header class="main-header navbar">--}}
{{--         @include('admin.layouts.navbar')--}}
{{--    </header>--}}

    <div class="container pb-4 m-0">
        @yield('content')
    </div>

    <footer class="main-footer font-xs" style="background-color: #e6e7e8;">
        <div class="row p-2 ms-4">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear());
                </script>
                &copy; Ethnic Admin Panel Management System - Senda Japan Ltd.
            </div>
        </div>
    </footer>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
<!-- Main Script -->
<script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        @if($errors->any())
            @foreach($errors->all() as $error)
                flasher.error('{{ $error }}', 'Error!');
            @endforeach
        @endif
    });
</script>

<script>

    function handleDeleteSuccess(data) {
        Swal.fire({
            title: "Deleted!",
            text: data.message,
            icon: "success"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }

    function handleDeleteError(xhr, status, error) {
        Swal.fire({
            title: "error : " + status,
            text: error,
            icon: "error"
        });
    }

</script>
@stack('scripts')

</body>

</html>

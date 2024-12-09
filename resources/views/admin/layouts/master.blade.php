<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>General Dashboard &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/flasher/flasher.min.css') }}">
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap-iconpicker.min.css') }}">
    @stack('css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <!-- Start GA -->
    {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>--}}
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA --></head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <!-- Navbar -->
        @include('admin.layouts.navbar')

        <!-- Sidebar Content -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2024
                <div class="bullet"></div>
                Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
            </div>
            <div class="footer-right">

            </div>
        </footer>
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
<script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/chart.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>--}}
<script src="{{ asset('/vendor/flasher/flasher.min.js') }}"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('backend/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>


<!-- Page Specific JS File -->
<script src="{{ asset('backend/assets/js/page/index-0.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
<script src="{{ asset('backend/assets/js/custom.js') }}"></script>

<script>

    @if($errors->any())
    @foreach($errors->all() as $error)

    flasher.error("{{ $error }}");

    @endforeach
    @endif
</script>

{{-- Dynamic delete alert --}}
<script>
    $(document).ready(function () {
        // Csrf token
        $.ajaxSetup({
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $('body').on('click', '.delete-item', function (e) {
            e.preventDefault();
            let deleteUrl = $(this).attr('href')

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,

                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: data.message,
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else if (data.status == 'error') {
                                Swal.fire({
                                    title: "You can't delete!",
                                    text: data.message,
                                    icon: "error"
                                })
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error)
                        }
                    })
                }
            });

        })
    })
</script>


@stack('scripts')
</body>
</html>

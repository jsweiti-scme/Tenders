<!doctype html>

<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('layouts.head-css')

</head>
<script>
    var locale = "{{ app()->getLocale() }}";
</script>
@section('body')
    @include('layouts.body')

@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content" dir="rtl">
        <div class="page-content" dir="rtl">
            <div class="container-fluid" dir="rtl">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <x-livewire-alert::scripts />
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')

</body>

</html>

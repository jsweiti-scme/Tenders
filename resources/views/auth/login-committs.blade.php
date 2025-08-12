@extends('layouts.master-without-nav')
@section('title')
@lang('translation.title')
@endsection
@section('content')
<style>
    .login-bg
    {
        background-image:url("{{ URL::asset('assets/images/login-bg.jpg') }}");
        background-position:50%;
        background-repeat:no-repeat;
        background-size:cover;
        height:100vh;
        
    }
    .login-wrapper
    {
        align-content: center;
        justify-content: center;
        height: 100%;
        padding-top: 10%;
    }
    .login-form
    {
        max-width: 600px;
        background-color: #ffffff8f;
        padding: 3rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        border-radius : 0.5rem;
    }

</style>

<div class="auth-page login-bg">
    <div class="container-fluid p-0 ">
        <div class="row g-0 login-wrapper">
            <div class="login-form">
                        <div class="d-flex flex-column h-100">
                            
                            <div>
                                <a href="{{ url('/') }}">
                                    <img src="{{ URL::asset('assets/images/login-logo.png') }}" alt="" style="height: auto;max-width:100%;">
                                </a>
                                <br>
                                <a href="{{ url('/auth/google') }}" class="btn btn-primary w-100 waves-effect waves-light">
                                    Login with Google
                                </a>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">جميع الحقوق محفوظة الكلية الذكية للتعليم الحديث  © <script>document.write(new Date().getFullYear())</script></p>
                                </div>
                            </div>

                        </div>
                <!-- end auth full page content -->
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/pass-addon.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/feather-icon.init.js') }}"></script>
@endsection

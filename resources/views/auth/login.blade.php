

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
                            </div>
                            <div class="auth-content my-auto">
                                <form class="mt-4 pt-2" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-floating form-floating-custom mb-4">
                                        <input id="email" type="email" placeholder="البريد الإلكتروني" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="input-username">البريد الإلكتروني</label>
                                        <div class="form-floating-icon">
                                        <i data-feather="users"></i>
                                        </div>
                                    </div>

                                    <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" id="password-input" placeholder="كلمة المرور" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                        </button>
                                        <label for="input-password">كلمة المرور</label>
                                        <div class="form-floating-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">@lang('translation.Login')</button>
                                    </div>
                                    <br><br>
                                    @if (session('error-message'))
                                        <div class="alert alert-danger">
                                            {{ session('error-message') }}
                                        </div>
                                        @php
                                         session()->forget('error-message');
                                        @endphp
                                    @endif
                                </form>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">جميع الحقوق محفوظة الكلية الذكية للتعليم الحديث  © <script>document.write(new Date().getFullYear())</script></p>
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

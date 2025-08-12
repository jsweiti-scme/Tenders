@extends('layouts.master-without-nav')
@section('title')
@lang('translation.title')
@endsection
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .step {
            display: none;
        }

        .active {
            display: block;
        }

        input {
            padding: 15px 20px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        input:focus {
            border: 1px solid #3889b7;
            outline: 0;
        }

        .invalid {
            border: 1px solid #ff1100;
        }

        .error-message {
            color: #ff1100;
            font-size: 0.875em;
            display: none;
        }

        #nextBtn,
        #prevBtn,
        #process {
            background-color: #3889b7;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
            transition: background-color 0.3s ease;
        }

        #prevBtn {
            background-color: #ffffff;
            color: #3889b7;
            border: 1px solid #3889b7;
        }

        #prevBtn:hover,
        #nextBtn:hover,
        #process:hover {
            background-color: #62a3c8;
            color: #ffffff;
        }

        .progress {
            margin-bottom: 20px;
        }

        .login-bg {
            background-image: url("{{ URL::asset('assets/images/login-bg.jpg') }}");
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }

        .login-wrapper {
            align-content: center;
            justify-content: center;
            height: 100%;
            padding-top: 10%;
        }

        .login-form {
            max-width: 500px;
            background-color: #ffffff8f;
            padding: 3rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }

        .progress-bg {
            background-color: #3889b7;
        }
    </style>

<body dir="rtl" class="auth-page login-bg">

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0 login-wrapper">
                <div class="login-form">
                    <div class="d-flex flex-column h-100">
                        <div>
                            <a href="{{ url('/') }}">
                                <img src="{{ URL::asset('assets/images/login-logo.png') }}" alt="" style="height: auto; max-width:100%;">
                            </a>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bg" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <form method="post" enctype="multipart/form-data" action="{{ route('register') }}">
                            @csrf
                            <div class="step active">
                                <h3 class="text-center mb-4">الخطوة 1</h3>
                                <h6 class="text-center mb-4">معلومات الدخول</h6>
                                <div class="mb-3">
                                    <input type="email" placeholder="البريد الإلكتروني" @error('email') is-invalid @enderror autocomplete="email"  name="email" required>
                                    <span class="error-message" id="email-error">يرجى إدخال بريد إلكتروني صالح.</span>
                                  
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="كلمة المرور" name="password"  required>
                                    <span class="error-message" id="password-error">يرجى إدخال كلمة بحيث تكون اطول من ٦ احرف وتحتوي على رقم و رمز وحرف على الاقل.</span>
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="تأكيد كلمة المرور" name="password_confirmation" required>
                                    <span class="error-message" id="password-confirm-error">يرجى تأكيد كلمة المرور بشكل صحيح.</span>
                                </div>
                            </div>

                            <div class="step">
                                <h3 class="text-center mb-4">الخطوة 2</h6>
                                <h6 class="text-center mb-4">معلومات الشركة</h6>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <input type="text" placeholder="اسم الشركة" name="company_name" required>
                                        <span class="error-message" id="company-name-error">يرجى إدخال اسم الشركة.</span>
                                    </div>
                                    <div class="mb-3">
                                        <input type="tel" placeholder="رقم الهاتف" name="phone_number" required>
                                        <span class="error-message" id="phone-number-error">يرجى ادخال رقم الهاتف بشكل صحيح</span>
                                    </div>
                                    <div class="mb-3">
                                        <input type="tel" placeholder="رقم جوال" name="mobile_number" required>
                                        <span class="error-message" id="mobile-number-error">يرجى إدخال رقم الجوال بشكل صحيح</span>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" id="city_id" name="city_id" required>
                                            <option value="null" disabled selected>المدينة</option>
                                            @foreach ($cities as $city)
                                                <option value="{{$city->id}}">{{$city->city}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-message" id="address-error">يرجى إختيار المدينة.</span>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" placeholder="العنوان" name="address" required>
                                        <span class="error-message" id="address-error">يرجى إدخال العنوان.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="step">
                                <h3 class="text-center mb-4">الخطوة 3</h3>
                                <h6 class="text-center mb-4">الوثائق</h6>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <input type="text" placeholder="رقم المشتغل المرخص" name="license_worker_number" required>
                                        <span class="error-message" id="license_worker_number-error">يرجى ادخال رقم المشتغل المرخص بشكل صحيح</span>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" placeholder="شهادة مشتغل مرخص " name="license_worker_certification" required accept=".pdf,image/jpeg,image/jpg,image/png">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" placeholder="شهادة خصم مصدر" name="discount_certification_issuer" required accept=".pdf,image/jpeg,image/jpg,image/png">
                                    </div>
                                    <div class="mb-3">
                                        <input type="date" placeholder="تاريخ انتهاء شهادة خصم المصدر" name="discount_certification_issuer_expired_date" required>
                                    </div>

                                </div>
                            </div>

                            <div class="form-footer d-flex">
                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">السابق</button>
                                <button type="button" id="nextBtn" onclick="nextPrev(1)">التالي</button>
                                <button type="submit" id="process" class="submit" style="display: none;">تسجيل</button>
                            </div>
                        </form>
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

</body>

@endsection
@section('script')
<script src="{{ URL::asset('assets/js/pages/pass-addon.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/feather-icon.init.js') }}"></script>
<script>
    let currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        let x = document.getElementsByClassName("step");
        x[n].style.display = "block";
        let progress = (n / (x.length - 1)) * 100;
        document.querySelector(".progress-bar").style.width = progress + "%";
        document.querySelector(".progress-bar").setAttribute("aria-valuenow", progress);
        document.getElementById("prevBtn").style.display = n == 0 ? "none" : "inline";
        document.getElementById("nextBtn").style.display = n == x.length - 1 ? "none" : "inline";
        document.getElementById("process").style.display = n == x.length - 1 ? "inline" : "none";
    }

    function nextPrev(n) {
        let x = document.getElementsByClassName("step");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= x.length) {
            document.querySelector("form").submit();
            return false;
        }
        showTab(currentTab);
    }

    function validateForm() {
        let valid = true;
        let x = document.getElementsByClassName("step");
        let y = x[currentTab].getElementsByTagName("input");
        
        for (let i = 0; i < y.length; i++) {
            if (y[i].value == "") {
                y[i].className += " invalid";
                valid = false;
            } else {
                y[i].classList.remove("invalid");
            }
        }

        if (currentTab == 0) {
            let email = document.getElementsByName("email")[0];
            let password = document.getElementsByName("password")[0];
            let passwordConfirm = document.getElementsByName("password_confirmation")[0];

            if (!validateEmail(email.value)) {
                document.getElementById("email-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("email-error").style.display = "none";
            }

            if (!validatePassword(password.value)) {
                document.getElementById("password-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("password-error").style.display = "none";
            }

            if (password.value !== passwordConfirm.value) {
                document.getElementById("password-confirm-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("password-confirm-error").style.display = "none";
            }
        }

        if (currentTab == 1) {
            let companyName = document.getElementsByName("company_name")[0];
            let phoneNumber = document.getElementsByName("phone_number")[0];
            let mobileNumber = document.getElementsByName("mobile_number")[0];
            let address = document.getElementsByName("address")[0];

            if (!validateOnlyChars(companyName.value)) {
                document.getElementById("company-name-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("company-name-error").style.display = "none";
            }

            if (!validateOnlyNumbersWithLength(phoneNumber.value)) {
                document.getElementById("phone-number-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("phone-number-error").style.display = "none";
            }

            if (!validateOnlyNumbersWithLength(mobileNumber.value)) {
                document.getElementById("mobile-number-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("mobile-number-error").style.display = "none";
            }

            if (!validateOnlyCharsWithDash(address.value)) {
                document.getElementById("address-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("address-error").style.display = "none";
            }
        }

        if (currentTab == 2) {
            let license_worker_number = document.getElementsByName("license_worker_number")[0];

            if (!validateOnlyNumbers(companyName.value)) {
                document.getElementById("license_worker_number-error").style.display = "block";
                valid = false;
            } else {
                document.getElementById("license_worker_number-error").style.display = "none";
            }
        }

        return valid;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
    
    function validatePassword(password) 
    {
        const re = /^(?=.*[a-zA-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;
        return re.test(password);
    }
    function validateOnlyChars(input) 
    {
        const re = /^[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FFa-zA-Z\s]+$/;
        return re.test(input);
    }

    function validateOnlyCharsWithDash(input) 
    {
        const re = /^[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FFa-zA-Z\s\-,]+$/;
        return re.test(input);
    }
    function validateOnlyNumbersWithLength(input) 
    {
        const re = /^\d{1,10}$/;
        return re.test(input);
    }

    function validateOnlyNumbers(input) {
        const re = /^\d+$/;
        return re.test(input);
    }





</script>
@endsection

<!-- JAVASCRIPT -->
<script src="{{ URL::asset('/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/feather-icons/feather-icons.min.js') }}"></script>


<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.8.1/mdb.min.js"></script>
<script>
    
if (locale == "en") {
    document.getElementsByTagName("html")[0].removeAttribute("dir");
    document.getElementById('bootstrap-style').setAttribute('href', '{{ URL::asset('assets/css/bootstrap.min.css') }}');
    document.getElementById('app-style').setAttribute('href', '{{ URL::asset('assets/css/app.min.css') }}');
} 
else {
    document.getElementById('bootstrap-style').setAttribute('href', '{{ URL::asset('assets/css/bootstrap.rtl.css') }}');
    document.getElementById('app-style').setAttribute('href', '{{ URL::asset('assets/css/app.rtl.css') }}');
    document.getElementsByTagName("html")[0].setAttribute("dir", "rtl");
}

</script>
@yield('script')

@yield('script-bottom')
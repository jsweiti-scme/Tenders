@if(Session::has('message'))
<br>
<p id="message" class="alert col-4 {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
@elseif(Session::has('error-message'))
<br>
<p id="error-message" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error-message') }}</p>
@elseif (Session::has('alert-error'))
@push('scripts')
<script>
    alert('Sum of grades is not equal to 100.');
</script>
@endpush
@endif

@extends('layouts.master')
@section('title') @lang('translation.Dashboards') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/datatables.net-buttons-bs4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<style>
    .select2-container 
    {
        z-index: 9999;
    }
</style>
@endsection
@section('content')
@if (auth()->user()->type)
@livewire('tenders.tenders-table')
@else
@livewire('tenders.committes-tender-table')
@endif
@endsection
@section('script')
<script>
    $(function()
    {   
        Livewire.on('CloseModel', function () {
            setTimeout(function () {
                    window.location.href = "{{ route('Tenders.index') }}";
                }, 1000); 
            });
    });
</script>
@endsection

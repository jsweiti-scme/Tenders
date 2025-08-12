@extends('layouts.master')
@section('title') @lang('translation.Dashboards') @endsection
@section('css')



@endsection
@section('content')


@can('عرض الاحصائيات')
@php
    $userCount = DB::table('users')->count();
    $totalPlans = DB::table('course_outline_details')->count();
    $uneditPlans = DB::table('course_outline_details')->where('status',-1)->count();
    $ineditPlans = DB::table('course_outline_details')->where('status',0)->count();
    $inheadPlans = DB::table('course_outline_details')->where('status',1)->count();
    $acceptsPlans = DB::table('course_outline_details')->where('status',2)->count();
    $rejectPlans = DB::table('course_outline_details')->where('status',3)->count();
    $unapprovePlans = DB::table('course_outline_details')->where('status',5)->where('approve',0)->count();
    $unstatesApprovePlane = DB::table('course_outline_details')->where('status','!=',5)->where('approve',0)->count();
    $approvePlans = DB::table('course_outline_details')->where('status',4)->where('approve',1)->count();

        
@endphp
<div class="card-body">
        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">عدد المُدرسين</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#16daf1" value="{{ $userCount - 2 }}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $userCount - 2 }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط لم تعدل</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#6b8e45" value="{{ $uneditPlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط قيد التعديل</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#6b8e45" value="{{ $ineditPlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط لدى مشرفي التخصصات</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#6b8e45" value="{{ $inheadPlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط مقبولة</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#6b8e45" value="{{ $acceptsPlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط مرفوضة</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#6b8e45" value="{{ $rejectPlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط معتمدة أكاديمياً</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#34c38f" value="{{ $approvePlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط مرفوضة أكاديمياً</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#34c38f" value="{{ $unapprovePlans}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="text-center" dir="ltr">
                    <h5 class="font-size-14 mb-3">خطط غير محددة أكاديمياً</h5>
                    <input class="knob" data-width="150" data-height="150" data-linecap=round
                            data-fgColor="#34c38f" value="{{ $unstatesApprovePlane}}" data-skin="tron" data-angleOffset="180"
                            data-readOnly=true data-thickness=".1" data-max="{{ $totalPlans }}"/>
                </div>
            </div>

        </div>
 
</div>
@else
<h1>@lang('translation.User_Welcome')<b> {{auth()->user()->name}} </b></h1>
@endcan



@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('assets/libs/jquery-knob/jquery-knob.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery-knob.init.js') }}"></script>
@endsection

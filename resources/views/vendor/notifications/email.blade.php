<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
مرحباً !
@endif
@endif

{{-- Intro Lines --}}
قم بالضغط على الزر بالاسفل لتحقق من البريد الإلكتروني

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
إذا لم تقم بإنشاء حساب، فلا يلزم اتخاذ أي إجراء آخر.

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "اذا كان هنالك مشكلة في الضغط على \"تأكيد البريد الإلكتروني\", قم بنسخ الرابط التالي \n".
    'ولصقه في المتصفح:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>

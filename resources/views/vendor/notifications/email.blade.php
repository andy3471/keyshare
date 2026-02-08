@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
<h1>{{ $greeting }}</h1>
@else
@if ($level === 'error')
<h1>@lang('Whoops!')</h1>
@else
<h1>@lang('Hello!')</h1>
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
<p>{{ $line }}</p>
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
    case 'success':
    case 'error':
        $color = $level;
        break;
    default:
        $color = 'primary';
}
?>

@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p>{{ $line }}</p>
@endforeach

{{-- Salutation --}}
<p>
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>{{ config('app.name') }}
@endif
</p>

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
<p>@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n" .
    'into your web browser:',
    ['actionText' => $actionText]
) <a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
@endslot
@endisset
@endcomponent

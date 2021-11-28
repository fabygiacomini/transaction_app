@component('mail::message')
# Você recebeu uma transferência!

Olá, {{ $payee }} !<br>

Você recebeu uma transferência de {{ $payer }} no valor de R$ {{ $value }} em {{ $date }}!<br>

{{--@component('mail::button', ['url' => ''])--}}
{{--Ver detalhes--}}
{{--@endcomponent--}}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
<img src="{{ asset('images/password.png') }}" alt="{{ config('app.name') }} Logo">

<h1> Hola </h1>
<h2>Tu nueva clave de acceso es {{ $newPass }}</h2>
<center>
<img src="{{ asset('images/pie.png') }}" alt="{{ config('app.name') }} Logo">
</center>

@endcomponent



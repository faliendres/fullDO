@component('mail::message')
<img src="{{ asset('images/solicitud.png') }}" alt="{{ config('app.name') }} Logo">
<h1>Hola</h1>

<h2>Tienes una solicitud de tipo {{ $solicituTipo }}
{{ $solicituDescripcion }} .
Esta Solicitud se encuentra en estado {{ $solicituEstado }}</h2>


@component('mail::button',['url'=>'https://google.com'])
 Buscador
@endcomponent
<center>
<img src="{{ asset('images/pie.png') }}" alt="{{ config('app.name') }} Logo">
</center>

@endcomponent
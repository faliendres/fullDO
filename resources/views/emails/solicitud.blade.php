@component('mail::message')
# Solicitud

Hola,

Tienes una solicitud de tipo {{ $solicituTipo }}
{{ $solicituDescripcion }} .
Esta Solicitud se encuentra en estado {{ $solicituEstado }}



Saludos,<br>

@endcomponent
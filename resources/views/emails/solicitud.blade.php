@component('mail::message')
# Solicitud

Hola,

Tienes una solicitud de tipo {{ $solicituTipo }}
{{ $solicituDescripcion }} .
Esta Solicitud se encuentra en un estado {{ $solicituEstado }}



Saludos,<br>

@endcomponent
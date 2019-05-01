@component('mail::message',['logoEmpresa' => $logoEmpresa])
	@include('emails.partials.mailHeader')
	<h1 class="main-title">Solicitud</h1>
	<p class="content">
		
			
		
	Hola <b>{{ $nombre }}</b>,<br>
	@if($tipo!='create') 
		Te informamos que {{$remitente?'has modificado':'se ha modificado'}} una solicitud de {{ $solicituTipo }}, el estado se actualizó a {{ $solicituEstado }} {{$remitente?', cuyo remitente es '.$remitente:''}}
	@else 
		Te informamos que {{$remitente?'tienes':'has enviado'}} una solicitud de {{ $solicituTipo }}, con estado {{ $solicituEstado }}{{$remitente?', cuyo remitente es '.$remitente:''}}
	@endif
	</p>
	<p class="content" style="width: 100%; text-align: center;">
		<br>
		<a href="{{route('home')}}" class="btn btn-primary" target="_blank" style="margin-bottom: 2em;"><b>INGRESAR</b></a>
	</p>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
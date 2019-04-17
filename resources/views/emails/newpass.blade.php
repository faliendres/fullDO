@component('mail::message')
	@include('emails.partials.mailHeader')
		<h1 class="main-title">Clave</h1>

	<p class="content">
		Hola <b>{{ $nombre }}</b>,<br>
		Tu nueva contraseña es {{ $newPass }}
	</p>
	<p class="content" style="width: 100%; text-align: center;">
		<br>
		<a href="{{route('home')}}" class="btn btn-primary" target="_blank" style="margin-bottom: 2em;"><b>INGRESAR</b></a>
	</p>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
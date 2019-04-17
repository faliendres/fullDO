@component('mail::message')
	@include('emails.partials.mailHeader')
	<h1 class="main-title">Bienvenid@!!</h1>
	<div class="fila">
		<div class="col-1">
			Hola <b>{{ $nombre }}</b>,<br>
			Te damos la bienvenida al nuevo portal que te facilitará la información de todos y la organización de equipos dentro de tu empresa.
		</div>
		<div class="col-2">
			<b>USUARIO</b><br>
			<div class="outline-border">{{$usuario}}</div><br>
			<b>CLAVE</b><br>
			<div class="outline-border">{{$password?:'123456'}}</div><br>
			<br>
			<a href="{{route('home')}}" class="btn btn-primary" target="_blank" style="margin-bottom: 2em;"><b>INGRESAR</b></a>
		</div>
	</div>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
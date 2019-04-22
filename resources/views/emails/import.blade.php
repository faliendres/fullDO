@component('mail::message')
	@include('emails.partials.mailHeader')
		<h1 class="main-title">Carga Masiva</h1>

	<p class="content">
		Hola <b>{{ $nombre }}</b>,<br>
		Se registraron {{$creados}} {{$type}} nuevos.
	</p>
	<p class="content" style="width: 100%; text-align: center;">
		<br>
	</p>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
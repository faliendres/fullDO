@component('mail::message',['logoEmpresa' => $logoEmpresa])
<img src="https://i.ibb.co/jZQXLWf/header.png">
<h1 class="main-title">Solicitud</h1>
<p class="content">
Hola <b>{{ $nombre }}</b>,<br>
Te informamos que tienes una solitud de {{ $solicituTipo }}, con estado {{ $solicituEstado }}
</p>
<br>
<p class="content" style="width: 100%; text-align: center;"><button class="btn btn-primary" type="button">INGRESAR</button></p>

<div class="row">
  <div class="column">
    <img src="{{ image_asset('empresas','logofulldo.png')}}">
  </div>
  <div class="column">
    <img src="{{ $logoEmpresa }}">
  </div>
</div>
<img src="https://i.ibb.co/59PVKN4/footer.png">
@endcomponent
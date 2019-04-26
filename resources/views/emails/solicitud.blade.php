@component('mail::message',['logoEmpresa' => $logoEmpresa])
	@include('emails.partials.mailHeader')
	<h1 class="main-title">Solicitud</h1>
	<p class="content">
	Hola <b>{{ $nombre }}</b>,<br>
	Te informamos que tienes una solitud de {{ $solicituTipo }}, con estado {{ $solicituEstado }}
	</p>
	<p class="content" style="width: 100%; text-align: center;">
		<br>
		<table style="width: 100%;text-align:center;" cellspacing="0" cellpadding="0">
	      	<tr>
	          	<td style="text-align:center;">
	              	<table style="margin:0 auto;" cellspacing="0" cellpadding="0">
	                 	 <tr>
	                      	<td style="border-radius: 2px;text-align:center;" bgcolor="#337ab7">
	                          	<a href="{{route('home')}}" target="_blank" style="padding: 8px 12px; border: 1px solid #337ab7;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;">
	                                  INGRESAR             
	                              </a>
	                      	</td>
	                  	</tr>
	              	</table>
	          	</td>
	      	</tr>
	    </table>
	</p>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
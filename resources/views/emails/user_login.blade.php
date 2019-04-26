@component('mail::message')
	@include('emails.partials.mailHeader')
	<h1 class="main-title">Bienvenid@!!</h1>
	<table style="padding-top:30px;">
	    <tr>
	        <td rowspan="3" style="text-align:justify;width: 60%;padding: 0 2em;">Hola <b>{{ $nombre }}</b>,<br>
				Te damos la bienvenida al nuevo portal que te facilitará la información de todos y la organización de equipos dentro de tu empresa.</td>
	        <td style="text-align:center;"><b>USUARIO</b><br>
				<div class="outline-border" style="border: 1px solid #ddd;border-radius: 4px;">{{$usuario}}</div><br></td>
	    </tr>
	    <tr>
	        <td style="text-align:center;"><b>CLAVE</b><br>
				<div class="outline-border" style="border: 1px solid #ddd;border-radius: 4px;">{{$password?:'123456'}}</div><br>
				<br></td>
	    </tr>
	    <tr>
	        <td><table style="width: 100%;text-align:center;" cellspacing="0" cellpadding="0">
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
			</td>
	    </tr>
	</table>
	@include('emails.partials.mailFooter',['logoEmpresa' => $logoEmpresa])
@endcomponent
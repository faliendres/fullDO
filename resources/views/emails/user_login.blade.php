@component('mail::message')

<img src="{{ asset('images/solicitud.png') }}" alt="{{ config('app.name') }} Logo">

            <tr>
                <td class="content-cell" align="center">
                    <h2> align="center"> Te damos la bienvenida al nuevo portal que te facilitará la información de todos y la organización de equipos dentro de tu empresa. </h2>

                </td>
            </tr>
 <h2>Usuario: {{ $User }}</h2>
  <h2>Password; {{ $newPass }}</h2>

@component('mail::button',['url'=>'https://google.com'])
 Buscador
@endcomponent
<center>
<img src="{{ asset('images/pie.png') }}" alt="{{ config('app.name') }} Logo">
</center>
@endcomponent
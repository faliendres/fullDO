@extends("layouts.general")
@section("page_styles")
    <style>
        .emp-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            max-height: 370px;
            max-width: 370px;
            width: 100%;
            height: 100%;
        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .table .avatar{
            width: 1px;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #1D0D89;
        }

        .profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .proile-rating {
            font-size: 12px;
            color: #818182;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head i {
            margin-right: 5px;
            width: 20px;
            text-align: center;
        }


        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #1D0D89;
        }

        .profile-work {
            padding: 14%;
            margin-top: -15%;
        }

        .profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-work a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work ul {
            list-style: none;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #1D0D89;
        }
        .fontsize10{
            font-size: 10px;
        }
        .fontsize12{
            font-size: 12px;
        }
        .fontsize13{
            font-size: 13px;
        }
        .table-stats .table {
            cursor: pointer;
        }
        .m-t-20{
          margin-top: 20px;
        }
        .td-email{
            text-transform:none !important;
        }
    </style>
@endsection
<!-- Content -->
@section("content")
    <div class="back-button">
        <a href="{{ route('organigrama') }} {{ isset($jefatura) ? ('?id='.$jefatura->id) : '' }} "><i class="fa fa-reply"></i> Volver</a>
        <p></p>
    </div>
    <div class="container emp-profile">       
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="profile-head">
                            <h2 style="margin-bottom: 10px;">{{$user->name}} {{$user->apellido}}</h2>
                            <h4 style="margin-bottom: 20px;">{{$cargo ? $cargo->nombre:'-'}}</h4>
                            <i class="fa fa-flag"></i><span>{{$user->gerencia ? $user->gerencia->nombre:'-'}}</span><br/>
                            <i class="fa fa-map-marker"></i><span>{{$user->empresa ? $user->empresa->nombre:'-'}}</span><br/>
                            <i class="fa fa-trophy"></i><span>Comenzó el {{ (new Date($user->fecha_inicio))->format('j F Y') }}</span><br/>    
                        </div>
                    </div>
                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <a href="{{ route('home') }}" class="btn btn-primary">Editar</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('organigrama') }}" class="btn btn-primary">Ver Organigrama</a>
                        </div>
                    </div>                    
                    <div class="card-body m-t-20">
                        <h5 class="box-title">Contact</h5>
                    </div>
                    <div class="table-stats ov-h">
                        <table class="contact" id="reports-contacts">
                            <tbody>
                                <tr class="contact"> 
                                    <td class="avatar">
                                        <i class="fa fa-envelope"></i>
                                    </td>
                                    <td><span class="fontsize13">EMAIL</span>
                                        <br>
                                        <span class="fontsize12 td-email">{{$user->email}}</span>
                                    </td>
                                </tr>           
                            </tbody>
                        </table>
                    </div>
                    <div class="row">             
                        <div class="col-md-4">
                            <div class="profile-work m-t-20">
                                @if(isset($cargo->adjuntos))                  
                                    <a>Perfil del Cargo:</a><br/>
                                    @include("partials.file",["readonly"=> "true", "name"=>"adjuntos","title"=>"","multiple"=>true, "value"=>$cargo->adjuntos, "resource" => "cargos"  ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 card" style="padding:30px;">
                    <div class="profile-img">
                        <img src="images\avatar\{{$user->foto}}" alt=""/>
                    </div>
                    @if($jefatura)
                        <div class="card-body">
                            <h5 class="box-title">Jefatura</h5>
                        </div>
                        <div class="table-stats ov-h">
                            <table class="table" id="reports-contacts">
                                <tbody>
                                    <tr class="pb-0" data-url="{{ route('perfil') }}?id={{$jefatura->funcionario->id}}"> 
                                        <td class="avatar">
                                            <div class="round-img">
                                                <img class="rounded-circle" src="images/avatar/{{$jefatura->funcionario->foto}}" alt="">
                                            </div>
                                        </td>
                                        <td><span class="fontsize13">{{ $jefatura->nombre }}</span>
                                            <br>
                                            <span class="fontsize12">{{ $jefatura->funcionario?$jefatura->funcionario->name . ' ' . $jefatura->funcionario->apellido:'' }}</span>
                                        </td>
                                        <td><i class="fa fa-angle-right"></i></td>
                                    </tr>           
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($cargo && count($cargo->subCargos)>0)
                        <div class="card-body">
                            <h5 class="box-title">Reportes Directos</h5>
                        </div>
                        <div class="table-stats ov-h">
                            <table class="table" id="reports-contacts">
                                <tbody>
                                    @foreach ($cargo->subCargos as $subCargo)
                                        @if ($subCargo->funcionario != null)
                                            <tr class="pb-0" data-url="{{ route('perfil') }}?id={{$subCargo->funcionario->id}}"> 
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        <img class="rounded-circle" src="images/avatar/{{$subCargo->funcionario->foto}}" alt="">
                                                    </div>
                                                </td>
                                                <td><span class="fontsize13">{{$subCargo->nombre}}</span>
                                                    <br>
                                                    <span class="fontsize12">{{ $subCargo->funcionario->name . ' ' . $subCargo->funcionario->apellido }}</span>
                                                </td>
                                                <td><i class="fa fa-angle-right"></i></td>
                                            </tr>           
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
@section("page_scripts")
<script type="text/javascript">

    $(function() {
      $('table.table').on("click", "tr.pb-0", function() {
        window.location = $(this).data("url");
      });
    });

</script>
@endsection
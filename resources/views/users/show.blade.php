@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Mostrar Usuario</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                @php
                                    $user=auth()->user();
                                    $holdings=toOptions(\App\Holding::query());
                                    if($holdings->count()===1)
                                        $empresas=toOptions(\App\Empresa::query()->where("id_holding",$holdings->first()["id"]));
                                    else
                                        $empresas=collect([]);
                                    if($empresas->count()===1)
                                        $gerencias=toOptions(\App\Gerencia::query()->where("id_empresa",$empresas->first()["id"]));
                                    else
                                        $gerencias=collect([]);
                                    if($gerencias->count()===1)
                                        $cargos=toOptions(\App\Cargo::query()->where("id_gerencia",$gerencias->first()["id"]));
                                    else
                                        $cargos=collect([]);
                                    $perfiles=[];
                                    if(!isset($user->perfil))
                                        $perfiles[]=["text"=>"Super Admin","id"=>0,"selected"=>false];
                                    if($user->perfil<1)
                                        $perfiles[]=["text"=>"Holding","id"=>1,"selected"=>false];
                                    if($user->perfil<2)
                                        $perfiles[]=["text"=>"Empresarial","id"=>2,"selected"=>false];
                                    if($user->perfil<3)
                                        $perfiles[]=["text"=>"Gerencial","id"=>3,"selected"=>false];
                                    if($user->perfil<4)
                                        $perfiles[]=["text"=>"Funcional","id"=>4,"selected"=>false];
                                @endphp

                                @include("partials.select",["required"=>true, "name"=>"holding_id","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
                                @include("partials.select",["selected"=>toOptions(\App\Empresa::query()->where("id",$instance->empresa_id)),
                                    "required"=>true, "name"=>"empresa_id","title"=>"Empresa","stable"=>$user->perfil>1,"options"=>$empresas])
                                @include("partials.select",["selected"=>toOptions(\App\Gerencia::query()->where("id",$instance->gerencia_id)),
                                    "required"=>true, "name"=>"gerencia_id","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias])
                                @include("partials.select",["selected"=>toOptions(\App\Cargo::query()->where("id_funcionario",$instance->id)),
                                    "required"=>true, "name"=>"cargo_id","title"=>"Cargo","stable"=>$cargos->count()==1,"options"=>$cargos])
                                @include("partials.field",["required"=>true,"name"=>"name","title"=>"Nombre"])
                                @include("partials.field",["name"=>"apellido","title"=>"Apellido"])
                                @include("partials.field",["required"=>true,"name"=>"email","type"=>"email","title"=>"Email"])
                                @include("partials.field",["name"=>"rut","title"=>"RUT"])
                                @include("partials.select",["required"=>true, "name"=>"perfil","title"=>"Perfil de Usuario","stable"=>$user->cargo_id,"options"=>$perfiles])
                                @include("partials.image",["required"=>true, "name"=>"foto","title"=>"Foto"])
                                @include("partials.switch",["name"=>"estado","title"=>"Estado","value"=>$instance->estado])
                            </div>
                        </div>
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
    </div>
@endsection
@section("page_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            $("select[name='holding_id']").change(function (e) {
                let route = "{!! route("empresas.index",[
                "filter"=>[
                    [
                        "field"=>"id_holding",
                        "op"=>"=",
                        "value"=>"_id"
                    ]
                ]
                ]) !!}".replace("_id", $(this).val());
                $.ajax({
                    url: route,
                    success: result => {
                        let $select = $("select[name='empresa_id']");
                        $select.empty();
                        $select.append(`<option value="" selected disabled>Seleccione por favor</option>`)
                        result.data.forEach((item) => {
                            $select.append(`<option value="${item.id}">${item.nombre}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
            $("select[name='empresa_id']").change(function (e) {
                let route = "{!! route("gerencias.index",[
                "filter"=>[
                    [
                        "field"=>"id_empresa",
                        "op"=>"=",
                        "value"=>"_id"
                    ]
                ]
                ]) !!}".replace("_id", $(this).val());
                $.ajax({
                    url: route,
                    success: result => {
                        let $select = $("select[name='gerencia_id']");
                        $select.empty();
                        $select.append(`<option value="" selected disabled>Seleccione por favor</option>`)
                        result.data.forEach((item) => {
                            $select.append(`<option value="${item.id}">${item.nombre}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
            $("select[name='gerencia_id']").change(function (e) {
                let route = "{!! route("cargos.index",[
                "filter"=>[
                    [
                        "field"=>"id_gerencia",
                        "op"=>"=",
                        "value"=>"_id"
                    ]
                ]
                ]) !!}".replace("_id", $(this).val());
                $.ajax({
                    url: route,
                    success: result => {
                        let $select = $("select[name='cargo_id']");
                        $select.empty();
                        $select.append(`<option value="" selected disabled>Seleccione por favor</option>`)
                        result.data.forEach((item) => {
                            $select.append(`<option value="${item.id}">${item.nombre}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
        });
    </script>

@endsection
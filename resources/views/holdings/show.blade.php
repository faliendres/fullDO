@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">
        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Mostrar Holding</h4>
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

                                @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])

                                @include("partials.field",["name"=>"descripcion","title"=>"Descripcion"])

                                @include("partials.image",["required"=>true, "name"=>"logo","title"=>"Logo","folder"=>"holdings"])
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
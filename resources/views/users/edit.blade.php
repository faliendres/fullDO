@extends("default.edit")

@section("form")
    @php
        $user=auth()->user();
        $holdings=toOptions(\App\Holding::query());
        if($instance->holding_id)
            $empresas=toOptions(\App\Empresa::query()->where("id_holding",$instance->holding_id));
        else
            $empresas=collect([]);
        if($instance->empresa_id)
            $gerencias=toOptions(\App\Gerencia::query()->where("id_empresa",$instance->empresa_id));
        else
            $gerencias=collect([]);
        if($instance->gerencia_id)
            $cargos=toOptions(\App\Cargo::query()->where("id_gerencia",$instance->gerencia_id));
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
    @include("partials.select",["required"=>true, "name"=>"holding_id","title"=>"Holding","stable"=>true,"options"=>$holdings, "value"=> $instance->holding_id ])
    @include("partials.select",["required"=>true, "name"=>"empresa_id","title"=>"Empresa","stable"=>true,"options"=>$empresas, "value"=> $instance->empresa_id])
    @include("partials.select",["required"=>true, "name"=>"gerencia_id","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias, "value"=> $instance->gerencia_id])
    @include("partials.select",["name"=>"cargo_id","value"=>!$instance->cargo?"":$instance->cargo->id,"title"=>"Cargo","options"=>$cargos])
    @include("partials.select",["required"=>true, "name"=>"perfil","title"=>"Perfil de Usuario","stable"=>$user->cargo_id,"options"=>$perfiles])

    @include("partials.field",["required"=>true,"name"=>"name","title"=>"Nombre"])
    @include("partials.field",["name"=>"apellido","title"=>"Apellido"])
    @include("partials.field",["required"=>true,"name"=>"email","type"=>"email","title"=>"Email"])
    @include("partials.field",["name"=>"rut","title"=>"RUT"])

@endsection
@section("page_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            $("#create_form select[name='holding_id']").change(function (e) {

                let $select = $("#create_form select[name='empresa_id']");
                $select.empty();
                $select.trigger("change");
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
                        $select.append(`<option value="" selected disabled>Seleccione por favor</option>`)
                        result.data.forEach((item) => {
                            $select.append(`<option value="${item.id}">${item.nombre}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
            $("#create_form select[name='empresa_id']").change(function (e) {

                let $select = $("#create_form select[name='gerencia_id']");
                $select.empty();
                $select.trigger("change");

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
                        $select.append(`<option value="" selected disabled>Seleccione por favor</option>`)
                        result.data.forEach((item) => {
                            $select.append(`<option value="${item.id}">${item.nombre}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
            $("#create_form select[name='gerencia_id']").change(function (e) {
                let $select = $("#create_form select[name='cargo_id']");
                $select.empty();
                $select.trigger("change");
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
                        $select.append(`<option value="" selected >Seleccione por favor</option>`)
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

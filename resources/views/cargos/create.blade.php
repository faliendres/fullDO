@extends("default.create")
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
@endphp


@section("form")
    @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
    @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.field",["name"=>"area","title"=>"Area"])
    @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
    @include("partials.field",["type"=>"date","name"=>"desde","title"=>"Desde"])
    @include("partials.field",["type"=>"date","name"=>"hasta","title"=>"Hasta"])
    @include("partials.select",["name"=>"id_funcionario","title"=>"Funcionario","options"=>toOptions(\App\User::query(),"id","name") ])

    @include("partials.select",["required"=>true,"name"=>"id_holding","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
    @include("partials.select",["required"=>true,"name"=>"id_empresa","title"=>"Empresa","stable"=>$user->perfil>1,"options"=>$empresas ])
    @include("partials.select",["required"=>true,"name"=>"id_gerencia","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias ])
    @include("partials.select",["name"=>"id_jefatura","title"=>"Cargo","options"=>$cargos ])
@endsection
@section("page_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            let $form = $("#create_form");


            $form.find("select[name='id_holding']").change(function (e) {
                let $select = $form.find("select[name='id_empresa']");
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
            $form.find("select[name='id_empresa']").change(function (e) {
                let $select = $form.find("select[name='id_gerencia']");
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
            $form.find("select[name='id_gerencia']").change(function (e) {
                let $select = $form.find("select[name='id_jefatura']");
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
@extends("default.create")
@php
    $user=auth()->user();
    $holdings=toOptions(\App\Holding::query());
    if($holdings->count()===1)
        $empresas=toOptions(\App\Empresa::query()->where("id_holding",$holdings->first()["id"]));
    else
        $empresas=collect([]);

@endphp


@section("form")
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre","value"=>old('name')])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion","value"=>old('descripcion')])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color","value"=>old('color')])
        @include("partials.select",["name"=>"id_holding","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
        @include("partials.select",["name"=>"id_empresa","title"=>"Empresa","stable"=>$user->perfil>1,"options"=>$empresas ])
@endsection
@section("page_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            let $form = $("#create_form");


            $form.find("select[name='id_holding']").change(function (e) {
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
                        let $select = $form.find("select[name='id_empresa']");
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
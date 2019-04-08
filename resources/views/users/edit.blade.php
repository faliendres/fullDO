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
        if($user->perfil<1 || $instance->perfil==1){
            $perfiles[]=["text"=>"Holding","id"=>1,"selected"=>false];
        }
        if($user->perfil<2 || $instance->perfil==2){
            $perfiles[]=["text"=>"Empresarial","id"=>2,"selected"=>false];    
        }
        if($user->perfil<3 || $instance->perfil==3)
            $perfiles[]=["text"=>"Gerencial","id"=>3,"selected"=>false];
        if($user->perfil<4)
            $perfiles[]=["text"=>"Funcional","id"=>4,"selected"=>false];
    @endphp

    @include("partials.field",["name"=>'validated',"type"=>"hidden","value"=>""])
    @include("partials.select",["required"=>true, "name"=>"holding_id","title"=>"Holding","stable"=>true,"options"=>$holdings, "value"=> $instance->holding_id ])
    @include("partials.select",["required"=>true, "name"=>"empresa_id","title"=>"Empresa","stable"=>true,"options"=>$empresas, "value"=> $instance->empresa_id])
    @include("partials.select",["required"=>true, "name"=>"gerencia_id","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias, "value"=> $instance->gerencia_id])
    @include("partials.select",["name"=>"cargo_id","value"=>!$instance->cargo?"":$instance->cargo->id,"title"=>"Cargo","options"=>$cargos])
    @include("partials.select",["required"=>true, "name"=>"perfil","title"=>"Perfil de Usuario","options"=>$perfiles])
    @include("partials.field",["required"=>true,"name"=>"name","title"=>"Nombre"])
    @include("partials.field",["name"=>"apellido","title"=>"Apellido"])
    @include("partials.field",["required"=>true,"name"=>"email","type"=>"email","title"=>"Email"])
    @include("partials.field",["name"=>"rut","title"=>"RUT"])
    @include("partials.field",["type"=>"number", "name"=>"telefono","title"=>"Teléfono"])
    
    @include("partials.field",["type"=>"date","name"=>"fecha_nacimiento","title"=>"Fecha de Nacimiento", "value"=>$instance->fecha_nacimiento ? Carbon\Carbon::parse($instance->fecha_nacimiento)->format('Y-m-d') : ''])

    @include("partials.field",["type"=>"date","name"=>"fecha_inicio","title"=>"Fecha de Contratación", "value"=>$instance->fecha_inicio ? Carbon\Carbon::parse($instance->fecha_inicio)->format('Y-m-d') : ''])
    @if(($user->perfil <= 3 ) || !isset($user->perfil))
        @include("partials.field",["name"=>"password","title"=>"Contraseña", "placeholder"=>"123456","type"=>"password"])
        @include("partials.field",["name"=>"password_confirmation","title"=>"Confirmar Contraseña","placeholder"=>"123456","type"=>"password"])
    @endif
    @include("partials.image",["name"=>"foto","title"=>"Foto"])
    @include("partials.switch",["name"=>"estado","title"=>"Estado"])

@endsection
@section("page_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            let $form = $("#create_form");
            $form.find("input[type='password']").val("");
            let $validated = $form.find("#validated");
            $form.on("submit", function (e) {
                if ($validated.val())
                    return true;
                e.preventDefault();

                let route = "{!! route("cargos.index",[
                "filter"=>[
                    [
                        "field"=>"id",
                        "op"=>"=",
                        "value"=>"_id"
                    ]
                ]
                ]) !!}".replace("_id", $(this).find("[name='cargo_id']").val());
                $.ajax({
                    url: route,
                    success: result => {
                        if (result.data.length && result.data[0].id_funcionario && result.data[0].id_funcionario!='{{$instance->id}}')  {
                            Swal.fire({
                                title: 'Cargo ocupado!',
                                text: "¿Seguro que desea reemplazarlo?",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Cancelar',
                                confirmButtonText: 'Sí'
                            }).then((result) => {
                                console.log(result.value);
                                if (result.value) {
                                    $validated.val(1);
                                    $form.trigger("submit");
                                }
                            });
                        }
                        else {
                            $validated.val(1);
                            $form.trigger("submit");
                        }

                    },
                    error: response => {
                    }
                });
            });



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

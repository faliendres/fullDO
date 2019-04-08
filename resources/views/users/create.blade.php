@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Nuevo Usuario</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                <form id="create_form" action="{{route("users.store")}}" method="POST"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" id="validated">
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
                                            $perfiles[]=["text"=>"Super Admin","id"=>0];
                                        if($user->perfil<1)
                                            $perfiles[]=["text"=>"Holding","id"=>1];
                                        if($user->perfil<2)
                                            $perfiles[]=["text"=>"Empresarial","id"=>2];
                                        if($user->perfil<3)
                                            $perfiles[]=["text"=>"Gerencial","id"=>3];
                                        if($user->perfil<4)
                                            $perfiles[]=["text"=>"Funcional","id"=>4];
                                    @endphp

                                    @include("partials.select",["name"=>"holding_id","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
                                    @include("partials.select",["name"=>"empresa_id","title"=>"Empresa","stable"=>$user->perfil>1,"options"=>$empresas])
                                    @include("partials.select",["name"=>"gerencia_id","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias])
                                    @include("partials.select",["name"=>"cargo_id","title"=>"Cargo","stable"=>$cargos->count()==1,"options"=>$cargos])
                                    @include("partials.field",["name"=>"name","title"=>"Nombre","value"=>old('name')])
                                    @include("partials.field",["name"=>"apellido","title"=>"Apellido","value"=>old('apellido')])
                                    @include("partials.field",["required"=>true,"name"=>"email","type"=>"email","title"=>"Email","value"=>old('email')])
                                    @include("partials.field",["required"=>true,"name"=>"rut","title"=>"RUT","value"=>old('rut')])
                                    @include("partials.field",["type"=>"number","name"=>"telefono","title"=>"Teléfono","value"=>old('telefono')])
                                    @include("partials.field",["type"=>"date","name"=>"fecha_nacimiento","title"=>"Fecha de Nacimiento","value"=>old('fecha_nacimiento')])
                                    @include("partials.field",["type"=>"date","name"=>"fecha_inicio","title"=>"Fecha de Contratación","value"=>old('fecha_inicio')])
                                    @include("partials.select",["name"=>"perfil","title"=>"Perfil de Usuario","stable"=>$user->cargo_id,"options"=>$perfiles])
                                    @include("partials.image",["name"=>"foto","title"=>"Foto"])
                                    @include("partials.field",["name"=>"password","title"=>"Contraseña",
                                    "placeholder"=>"123456","type"=>"password"])
                                    @if(!isset($readonly)||!$readonly)
                                        @include("partials.field",["name"=>"password_confirmation","title"=>"Confirmar Contraseña",
                                        "placeholder"=>"123456","type"=>"password"])
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Guardar
                                            </button>
                                        </div>
                                    @endif
                                </form>
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
            let $form = $("#create_form");

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
                        if (result.data.length && result.data[0].id_funcionario) {
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

            $form.find("select[name='holding_id']").change(function (e) {
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
                        let $select = $form.find("select[name='empresa_id']");
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
            $form.find("select[name='empresa_id']").change(function (e) {
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
                        let $select = $form.find("select[name='gerencia_id']");
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
            $form.find("select[name='gerencia_id']").change(function (e) {
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
                        let $select = $("#create_form select[name='cargo_id']");
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
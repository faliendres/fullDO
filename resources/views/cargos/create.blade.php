@extends("default.create")
@php
    $user=auth()->user();
    $users=toOptions(\App\User::query()->select(DB::raw("CONCAT(name,' ',apellido,' [',rut,']') AS full_name, id")),"id","full_name");
    $holdings=toOptions(\App\Holding::query());
    if($holdings->count()===1)
        $empresas=toOptions(\App\Empresa::query()->where("id_holding",$holdings->first()["id"]));
    else
        $empresas=collect([]);
    if($empresas->count()===1)
        $gerencias=toOptions(\App\Gerencia::query()->where("id_empresa",$empresas->first()["id"]));
    else
        $gerencias=collect([]);
    $options=\App\Cargo::options();
@endphp

@section("form")
    @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre", "value"=>old('name')])
    @include("partials.field",["name"=>"area","title"=>"Area", "value"=>old('area')])
    @include("partials.field",["type"=>"date","name"=>"desde","title"=>"Desde", "value"=>old('desde')])
    @include("partials.field",["type"=>"date","name"=>"hasta","title"=>"Hasta", "value"=>old('hasta')])
    @include("partials.select",["name"=>"id_funcionario","title"=>"Funcionario","options"=>$users ])
    @include("partials.select",["required"=>true,"name"=>"id_holding","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
    @include("partials.select",["required"=>true,"name"=>"id_empresa","title"=>"Empresa","stable"=>$user->perfil>1,"options"=>$empresas ])
    @include("partials.select",["required"=>true,"name"=>"id_gerencia","title"=>"Gerencia","stable"=>$user->perfil>2,"options"=>$gerencias ])


    @php
        $auxId=uniqid("id_jefatura");
    @endphp
    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label">Jefatura</label></div>
        <div class="col-12 col-md-9">
            <select name="id_jefatura" id="{{$auxId}}" class="form-control-lg form-control {{ $errors->has("id_jefatura") ? ' is-invalid' : '' }}">
                <option selected value="" {{(isset($required)&&$required)?"disabled":""}} >{{$placeholder??"Seleccione por favor"}}
                </option>
                @foreach($options as $holding_id=>$empresas)
                    <optgroup label="{{$holding_id}}">
                        @foreach($empresas as $empresa_id=>$gerencias)
                            <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{$empresa_id}}">
                                @foreach($gerencias as $gerencia_id=>$cargos)
                                    <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{$gerencia_id}}">
                                        @foreach($cargos as $cargo)
                                            <option value="{{$cargo->id}}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$cargo->text}}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @if ($errors->has("id_jefatura"))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("id_jefatura") }}</strong>
                    </span>
            @endif
        </div>
    </div>


    @include("partials.file",["name"=>"adjuntos","title"=>"Descripción de Cargo","multiple"=>false ])
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
                            $select.append(`<option value="${item.id}">${item.nombregerencia}</option>`)
                        });
                    },
                    error: response => {
                    }
                });
            });
            $form.find("select[name='id_gerencia']").change(function (e) {
                return;
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
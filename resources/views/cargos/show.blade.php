@extends("default.show")

@section("form")
    @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
    @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.field",["name"=>"area","title"=>"Area"])
    @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
    @include("partials.field",["type"=>"date","name"=>"desde","title"=>"Desde"])
    @include("partials.field",["type"=>"date","name"=>"hasta","title"=>"Hasta"])

    @include("partials.field",["name"=>"id_holding","title"=>"Holding","value"=>$instance->gerencia->empresa->holding->nombre ])
    @include("partials.field",["name"=>"id_empresa","title"=>"Empresa","value"=>$instance->gerencia->empresa->nombre ])
    @include("partials.field",["name"=>"id_gerencia","title"=>"Gerencia","value"=>$instance->gerencia->nombre ])

    @include("partials.field",["name"=>"id_jefatura","title"=>"Jefatura","value"=>!$instance->jefatura?"":$instance->jefatura->nombre ])
    @include("partials.field",["name"=>"id_funcionario","title"=>"Funcionario","value"=>!$instance->funcionario?"":$instance->funcionario->name ])
    @include("partials.switch",["name"=>"estado","title"=>"Estado","value"=>$instance->estado])

    @include("partials.image",["required"=>true, "name"=>"foto","title"=>"Foto","value"=>!$instance->funcionario?"":url('/').'/images/avatar/'.$instance->funcionario->foto])
@endsection
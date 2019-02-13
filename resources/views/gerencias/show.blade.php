@extends("default.show")



@section("form")
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
        @include("partials.field",["name"=>"id_holding","title"=>"Holding","value"=>$instance->empresa->holding->nombre ])
        @include("partials.field",["name"=>"id_empresa","title"=>"Empresa","value"=>$instance->empresa->nombre ])
@endsection
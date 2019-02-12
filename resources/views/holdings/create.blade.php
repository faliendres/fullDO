@extends("default.create")

@section("form")
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
        @include("partials.image",["name"=>"logo","title"=>"Logo"])
@endsection

@extends("default.create")

@section("form")
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre", "value"=>old('name')])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion", "value"=>old('descripcion')])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color", "value"=>old('color')])
        @include("partials.image",["name"=>"logo","title"=>"Logo"])
@endsection

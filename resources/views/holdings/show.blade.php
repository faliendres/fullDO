@extends("default.show")

@section("form")
    @include("partials.field",["name"=>"nombre","title"=>"Nombre"])
    @include("partials.field",["name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
    @include("partials.image",["name"=>"logo","title"=>"Logo","folder"=>"holdings"])
@endsection
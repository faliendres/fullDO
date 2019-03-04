@extends("default.create")
@php
    $user=auth()->user();
    $holdings=toOptions(\App\Holding::query());
@endphp

@section("form")
        @include("partials.field",["required"=>true,"name"=>"rut","title"=>"RUT","value"=>old('rut')])
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre","value"=>old('nombre')])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion","value"=>old('descripcion')])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color","value"=>old('color')])
        @include("partials.field",["type"=>"date","name"=>"desde","title"=>"Desde","value"=>old('desde')])
        @include("partials.field",["type"=>"date","name"=>"hasta","title"=>"Hasta","value"=>old('hasta')])
        @include("partials.image",["name"=>"logo","title"=>"Logo"])
        @include("partials.select",["required"=>true,"name"=>"id_holding","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
@endsection

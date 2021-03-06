@extends("default.edit")
@php
    $user=auth()->user();
    $holdings=toOptions(\App\Holding::query());
@endphp

@section("form")
	@include("partials.field",["required"=>true,"name"=>"rut","title"=>"RUT"])
	@include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
	@include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
	@include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
	@include("partials.field",["type"=>"date","name"=>"desde","title"=>"Desde"])
	@include("partials.field",["type"=>"date","name"=>"hasta","title"=>"Hasta"])
	@include("partials.image",["name"=>"logo","title"=>"Logo"])
	@include("partials.select",["name"=>"id_holding","title"=>"Holding","stable"=>$user->perfil>0,"options"=>$holdings ])
	@include("partials.switch",["name"=>"estado","title"=>"Estado"])
@endsection

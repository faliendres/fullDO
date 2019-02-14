@extends("default.edit")
@php
    $user=auth()->user();
    $holdings=toOptions(\App\Holding::query());
    if($holdings->count()===1)
        $empresas=toOptions(\App\Empresa::query()->where("id_holding",$holdings->first()["id"]));
    else
        $empresas=collect([]);

@endphp


@section("form")
        @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
        @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
        @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
        
@endsection

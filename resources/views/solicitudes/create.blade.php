@extends("default.create")
@php
    $users=toOptions(\App\User::get_nombre_cargo(),"id","full_name");
    $tipos=collect(\App\Solicitud::TIPOS)->map(function ($item,$key){
        return [
            "text" => $item,
            "id" => $key
        ];
    });
@endphp

@section("form")
    <input id="remitente_id" name="remitente_id" type="hidden" value="{{ auth()->user()->id }}">
    @include("partials.select",["required"=>true,"name"=>"tipo","title"=>"Tipo","options"=>$tipos ])
    @include("partials.field",["required"=>true,"name"=>"asunto","title"=>"Asunto"])
    @include("partials.textArea",["required"=>true,"name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.select",["required"=>true,"name"=>"destinatario_id","title"=>"Destinatario","options"=>$users ])
    @include("partials.file",["name"=>"adjuntos","title"=>"Adjuntos","multiple"=>true ])
@endsection

@extends("default.edit")
@php
    $users=toOptions(\App\User::get_nombre_cargo(),"id","full_name");
    $tipos=collect(\App\Solicitud::TIPOS)->map(function ($item){
        return [
        "text" => $item,
        "id" => $item
        ];
    });
@endphp

@section("form")
    @include("partials.select",["required"=>true,"name"=>"tipo","title"=>"Tipo","options"=>$tipos ])

    @include("partials.field",["required"=>true,"name"=>"asunto","title"=>"Asunto"])
    @include("partials.textArea",["required"=>true,"name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.select",["required"=>true,"name"=>"destinatario_id","title"=>"Destinatario","options"=>$users ])
    @include("partials.file",["name"=>"adjuntos","title"=>"Adjuntos","multiple"=>true ])
    @include("partials.switch",["name"=>"estado","title"=>"Estado","value"=>$instance->estado])

@endsection

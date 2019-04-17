@extends("default.edit")
@php
    $users=toOptions(\App\User::get_nombre_cargo(),"id","full_name");
    if($instance->destinatario_id == auth()->user()->id) // si la solicitud a editar va dirigida al usuario actual
        $users->push([
            "text" => auth()->user()->name.' '.auth()->user()->apellido,
            "id" => auth()->user()->id
        ]);
    $tipos=collect(\App\Solicitud::TIPOS)->map(function ($item,$key){
        return [
        "text" => $item,
        "id" => $key
        ];
    });
    $estados=collect(\App\Solicitud::ESTADOS);
@endphp

@section("form")
    @include("partials.select",["required"=>true,"name"=>"tipo","title"=>"Tipo","options"=>$tipos ])

    @include("partials.field",["required"=>true,"name"=>"asunto","title"=>"Asunto"])
    @include("partials.textArea",["required"=>true,"name"=>"descripcion","title"=>"Descripcion"])
    @include("partials.select",["required"=>true,"name"=>"destinatario_id","title"=>"Destinatario","options"=>$users ])
    @include("partials.file",["name"=>"adjuntos","title"=>"Adjuntos","multiple"=>true ])
    @include("partials.textArea",["required"=>true,"name"=>"comentarios","title"=>"Comentarios"])
    @include("partials.select",["required"=>true, "name"=>"estado","title"=>"Estado","options"=>$estados])

@endsection

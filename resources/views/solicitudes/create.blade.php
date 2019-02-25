@extends("default.create")
@php
    $users=toOptions(\App\User::query(),"id","name");
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
    @include("partials.file",["required"=>true,"name"=>"adjuntos","title"=>"Adjuntos","multiple"=>true ])
@endsection

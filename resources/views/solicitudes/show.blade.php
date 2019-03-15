@extends("default.show")

@php
    $estados=collect(\App\Solicitud::ESTADOS);
    $instance->estado = ($estados->where('id',$instance->estado)->first())['text'];
@endphp

@section("form")
        @include("partials.field",["required"=>true,"name"=>"tipo","title"=>"Tipo"])
        @include("partials.field",["required"=>true,"name"=>"asunto","title"=>"Asunto"])
        @include("partials.textArea",["required"=>true,"name"=>"descripcion","title"=>"Descripcion"])
        @include("partials.field",["name"=>"destinatario_id","title"=>"Destinatario","value"=>$instance->destinatario->name ])
        @include("partials.file",["required"=>true,"name"=>"adjuntos","title"=>"Adjuntos","multiple"=>true ])
        @include("partials.textArea",["required"=>true,"name"=>"comentarios","title"=>"Comentarios"])
        @include("partials.field",["name"=>"estado","title"=>"Estado"])
@endsection

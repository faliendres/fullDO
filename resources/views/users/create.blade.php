@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Nuevo Usuario</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                <form action="{{route("users.store")}}" method="POST">
                                    {{csrf_field()}}
                                    @php
                                        $user=auth()->user();
                                        $holdings=toOptions(\App\Holding::query());
                                        if($holdings->count()===1)
                                            $empresas=toOptions(\App\Empresa::query()->where("id_holding",$holdings->first()["id"]));
                                        else
                                            $empresas=collect([]);
                                        if($empresas->count()===1)
                                            $gerencias=toOptions(\App\Gerencia::query()->where("id_empresa",$empresas->first()["id"]));
                                        else
                                            $gerencias=collect([]);
                                    @endphp

                                    @include("partials.select",["required"=>true, "name"=>"holding_id","title"=>"Holding","stable"=>$user->holding_id,"options"=>$holdings ])
                                    @include("partials.select",["required"=>true, "name"=>"empresa_id","title"=>"Empresa","stable"=>$user->empresa_id,"options"=>$empresas])
                                    @include("partials.select",["required"=>true, "name"=>"gerencia_id","title"=>"Gerencia","stable"=>$user->gerencia_id,"options"=>$gerencias])
                                    @include("partials.field",["required"=>true,"name"=>"password","title"=>"","type"=>"hidden","value"=>"123456"])
                                    @include("partials.field",["required"=>true,"name"=>"name","title"=>"Nombre"])
                                    @include("partials.field",["name"=>"apellido","title"=>"Apellido"])
                                    @include("partials.field",["required"=>true,"name"=>"email","type"=>"email","title"=>"Email"])
                                    @include("partials.field",["name"=>"rut","title"=>"RUT"])
                                    <div class="form-actions">
                                        <button type="submit    " class="btn btn-primary">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
    </div>
@endsection

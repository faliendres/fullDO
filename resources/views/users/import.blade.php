@extends("layouts.general")

@section("content")
    <div class="animated fadeIn">
        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Importar {{__($resource)}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <form id="create_form" action="{{route("$resource.import")}}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    @include("partials.file",["name"=>"file","title"=>"Archivo para Importar",
                                    "accept"=>".xlsx"])
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
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
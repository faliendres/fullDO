@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Nuevo Holding</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                <form id="create_form" action="{{route("holdings.store")}}" method="POST"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    @include("partials.field",["required"=>true,"name"=>"nombre","title"=>"Nombre"])
                                    @include("partials.textArea",["name"=>"descripcion","title"=>"Descripcion"])
                                    @include("partials.image",["name"=>"logo","title"=>"logo"])
                                    @include("partials.field",["type"=>"color","name"=>"color","title"=>"Color"])
                                @if(!isset($readonly)||!$readonly)
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                    @endif
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

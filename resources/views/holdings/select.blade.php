@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Seleccione un Holding</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                <form  >
                                    @include("partials.select",[
                                "name"=>"holding_id","title"=>"Holding","options"=>toOptions(\App\Holding::query()),"placeholder"=>"Todos" ])
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Listar
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

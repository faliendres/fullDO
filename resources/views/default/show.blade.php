@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Mostrar {{__($resource)}}</h4>
                        <a href="{{route("$resource.edit",["id"=>$instance->id])}}" class="btn btn-warning pull-right"><i class="fa fa-edit"></i>Modificar</a>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                @yield("form")
                            </div>
                        </div>
                    </div> <!-- /.row -->
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
    </div>
@endsection

@extends("layouts.general")

@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Nuevo {{__($resource)}}</h4>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-body">
                                <form id="create_form" action="{{route("$resource.store")}}" method="POST"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    @yield("form")
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

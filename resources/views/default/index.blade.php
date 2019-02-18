@extends("layouts.general")
@section("page_styles")
    <link rel="stylesheet" href="{{asset("assets/css/lib/datatable/dataTables.bootstrap.min.css")}}">
@endsection
@section("content")

    <div class="animated fadeIn">

        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">{{__($resource)}} </h4>
                        <a href="{{route("$resource.create")}}" class="btn btn-primary">Nuevo</a>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <table class="table table-striped table-responsive">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- /.row -->
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
    </div>
@endsection

@section("page_scripts")
    <script src="{{asset("assets/js/lib/data-table/datatables.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/dataTables.bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/dataTables.buttons.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/buttons.bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/jszip.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/vfs_fonts.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/buttons.html5.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/buttons.print.min.js")}}"></script>
    <script src="{{asset("assets/js/lib/data-table/buttons.colVis.min.js")}}"></script>
    <script src="{{asset("assets/js/init/datatables-init.js")}}"></script>

    @yield("index_scripts")

    <script type="text/javascript">
        $(document).ready(function () {
            let route = "{!! request()->fullUrl() !!}";
            let $table = $('table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": route,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "columns": columns
            });
            $table.on("click", ".btn-danger", function (e) {
                let data = $(this).data("id");
                let route = "{{route("$resource.destroy",["_id"])}}".replace("_id", data);
                let $row = $(this).parents("tr").first();
                Swal.fire({
                    title: '¿Esta seguro?',
                    text: "Esta accion no podra ser revertida",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Sí'
                }).then((result) => {
                    if (result.value) {
                        $.ajax(
                            {
                                url: route,
                                type: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                                },
                                success: result => {
                                    $table.row($row)
                                        .remove()
                                        .draw();
                                },
                                error: response => {
                                    Swal.fire({
                                        title: 'Ha ocurrido un error',
                                        text: response.responseJSON.message,
                                        type: 'error'
                                    });

                                }
                            }
                        )
                    }

                });

            });
        });
    </script>

@endsection

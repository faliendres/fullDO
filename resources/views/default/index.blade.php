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
                    @if(auth()->user()->perfil <= 3 )
                        <div class="card-body">
                            <h4 class="box-title" style="text-transform: capitalize; text-align: center;">{{__($resource)}} </h4>
                            <a href="{{route("$resource.create")}}" class="btn btn-primary">Nuevo</a>
                        </div>
                    @endif
                    <div class="row card-body">
                        <div class="form-group col-md-offset-1 col-md-4 holding" style="display: none">
                            <h5>Seleccionar Holding <span class="text-danger"></span></h5>
                            <select id="Holdings" class="form-control">
                                <option value="">Todos </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 empresas" style="display: none">
                            <h5>Seleccionar Empresa <span class="text-danger"></span></h5>
                            <select id="Empresas" class="form-control">
                                <option value="">Todos </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 gerencias" style="display: none">
                            <h5>Seleccionar Gerencia <span class="text-danger"></span></h5>
                            <select id="Gerencias" class="form-control">
                                <option value="">Todos </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <table class="table table-striped">
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
    <script src="{{asset("assets/js/filterDropDown.js")}}"></script>
    <script src="{{asset("assets/js/init/datatables-init.js")}}"></script>

    @yield("index_scripts")

    <script type="text/javascript">
        $(document).ready(function () {

            if(typeof filterDropDown ==="undefined")
                var filterDropDown={};
            let route = "{!! request()->fullUrl() !!}";
            let $table = $('table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": route,
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    } 
                },
                filterDropDown: filterDropDown,
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
            if(typeof filterSelect != "undefined") {
                if (filterSelect.indexOf("Holding") >= 0) {
                    $('.holding').show();
                    $.ajax({
                        url: '{{route("holdings.index")}}',
                        type: 'GET',
                        success: function (response) { // What to do if we succeed
                            $.each(response.data, function () {
                                $("#Holdings").append('<option value="' + this.id + '">' + this.nombre + '</option>');
                            });
                        },
                    });

                    $('#Holdings').on('change', function () {
                        var filter_value = $(this).val();
                        $table
                            .columns(1)
                            .search(filter_value ? '^'+filter_value+'$' : '',true, false)
                            .draw();
                    });
                }

                if (filterSelect.indexOf("Empresas") >= 0) {
                    $('.empresas').show();
                    $.ajax({
                        url: '{{route("empresas.index")}}',
                        type: 'GET',
                        success: function (response) { // What to do if we succeed
                            $.each(response.data, function () {
                                $("#Empresas").append('<option value="' + this.id + '">' + this.nombre + '</option>');
                            });
                        },
                    });

                    $('#Empresas').on('change', function () {
                        var filter_value = $(this).val();
                        $table
                            .columns(2)
                            .search(filter_value ? '^'+filter_value+'$' : '',true, false)
                            .draw();
                    });
                }

                if (filterSelect.indexOf("Gerencias") >= 0) {
                    $('.gerencias').show();
                    $.ajax({
                        url: '{{route("gerencias.index")}}',
                        type: 'GET',
                        success: function (response) { // What to do if we succeed
                            $.each(response.data, function () {
                                $("#Gerencias").append('<option value="' + this.id + '">' + this.nombregerencia + '</option>');
                            });
                        },
                    });

                    $('#Gerencias').on('change', function () {
                        var filter_value = $(this).val();
                        $table
                            .column(4)
                            .search(filter_value ? '^'+filter_value+'$' : '',true, false)
                            .draw();
                    });
                }
            }
        });
    </script>

@endsection

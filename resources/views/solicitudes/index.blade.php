@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var base_logos = "{{image_asset($resource)}}";
        var tipos = JSON.parse('{!! json_encode(\App\Solicitud::TIPOS)  !!}');
        var isBuzon = parseInt('{{(request()->getPathInfo()=='/solicitudes/buzon')?1:0}}');
        var columns = [
            {
                "data": "tipo", "title": "Tipo",
                "render": function (data, row) {
                    return `<span>${tipos[data]}</span>`;
                }
            },
            {"data": "asunto", "title": "Asunto"},
            {
                "data": "destinatario.name",
                "title": "Destinatario",
                "visible":!isBuzon
            },
            {
                "data": "remitente.name",
                "title": "Remitente",
                "render": function (data, field, row) {
                    return `<span >${row.remitente.rut} ${row.remitente.name} ${row.remitente.apellido}</span>`;
                },
                "visible":isBuzon
            },
            {
                "data": "created_at",
                "title": "Fecha de creación"
            },
            {
                "data": "estado", "title": "Estado",
                "render": function (data, field, row) {
                    let color = 'red';
                    if (data == 2)
                        color = 'yellow';
                    else if (data == 3)
                        color = 'green';
                    return `<span style="color: ${color}"><i class="fa fa-circle fa-2x"></i></span>`;
                }
            },
            {
                "data": "id", "title": "Acciones",
                "render": function (data, row) {
                    let show = "{{route("$resource.show",["_id"])}}".replace("_id", data);
                    let edit = "{{route("$resource.edit",["_id"])}}".replace("_id", data);
                    return `
                    <div class="btn-group">
    <a class="btn btn-primary" data-id="${data}" href="${show}">
        <i class="fa fa-search"></i>
    </a>
    <a style="display: {{($resource=='solicitudes' && $noEdit)?'none':'block'}};" class="btn btn-warning white-color" data-id="${data}" href="${edit}">
        <i class="fa fa-edit"></i>
    </a>
    <button class="btn btn-danger" data-id="${data}">
        <i class="fa fa-times"></i>
    </button>
</div>
`;
                }
            },
        ];
    </script>
@endsection

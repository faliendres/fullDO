@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var base_logos = "{{image_asset($resource)}}";
        var columns = [
            {"data": "nombre", "title": "Nombre"},
            {"data": "area", "title": "area"},
            {"data": "gerencia.nombre", "title": "Gerencia"},
            {"data": "gerencia.empresa.nombre", "title": "Empresa","orderable": false,},
            {"data": "gerencia.empresa.holding.nombre", "title": "Holding","orderable": false,},
            {
                "data": "jefatura", "title": "Jefatura",
                "render": function (data, row) {
                    if (!data)
                        return "";
                    return `<span>${data.nombre}</span>`;
                }
            },
            {
                "data": "funcionario", "title": "Funcionario",
                "render": function (data, row) {
                    if (!data)
                        return "";
                    return `<span>${data.name}</span>`;
                }
            },
            {
                "data": "id", "title": "Acciones",
                "render": function (data, row) {
                    let show = "{{route("$resource.show",["_id"])}}".replace("_id", data);
                    let edit = "{{route("$resource.edit",["_id"])}}".replace("_id", data);
                    return `
                    <div class="btn-group" >
                    <a class="btn btn-primary" data-id="${data}" href="${show}">
                        <i class="fa fa-search"></i>
                    </a>
                    <a class="btn btn-warning white-color" data-id="${data}" href="${edit}">
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

@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var columns = [
            {"data": "id", "title": "Id"},
            {"data": "name", "title": "Nombre"},
            {"data": "apellido", "title": "Apellido"},
            {"data": "email", "title": "Email"},
            {"data": "perfil", "title": "Perfil"},
            {
                "data": "id", "title": "Acciones",
                "render": function (data, row) {
                    let route = "{{route("users.show",["_id"])}}".replace("_id", data);
                    return `
                    <div class="btn-group">
    <a class="btn btn-primary" data-id="${data}" href="${route}">
        <i class="fa fa-search"></i>
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

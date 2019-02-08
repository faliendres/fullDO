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
                    return `<button class="btn btn-danger" data-id="${data}"><i class="fa fa-times"></i></button>`;
                }
            },
        ];
    </script>
@endsection

@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var base_logos="{{image_asset($resource)}}";

        var columns = [
            {"data": "foto", "title": "Avatar",
                "render": function (data, row) {
                    if(!data)
                        return "";
                    if (!data.startsWith("http")){
                        data=base_logos+"/"+data;
                    }
                    return `<img class="rounded-circle" style="width:85px;height:85px;" alt="avatar" src="${data}">`;
                }
            },
            {"data": "rut", "title": "Rut"},
            {"data": "name", "title": "Nombre"},
            {"data": "apellido", "title": "Apellido"},
            {"data": "email", "title": "Email"},
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

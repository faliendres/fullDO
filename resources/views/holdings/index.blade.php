@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var base_logos="{{asset("/images/holdings")}}"
        var columns = [
            {
                "data": "logo",
                "render": function (data, row) {
                    if(!data)
                        return "";
                    if (!data.startsWith("http")){
                        data=base_logos+"/"+data;
                    }
                    return `<img class="rounded-circle" style="width:85px;height:85px;" alt="" src="${data}">`;
                }
            },
            {"data": "nombre", "title": "Nombre"},
            {"data": "estado", "title": "Estado"},
            {
                "data": "id", "title": "Acciones",
                "render": function (data, row) {
                    let show = "{{route("holdings.show",["_id"])}}".replace("_id", data);
                    let edit = "{{route("holdings.edit",["_id"])}}".replace("_id", data);
                    return `
                    <div class="btn-group">
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

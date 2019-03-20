@extends("default.index")
@section("index_scripts")
    <script type="text/javascript">
        var base_logos = "{{image_asset($resource)}}";
        var perfil = "{{ auth()->user()->perfil }}";
        if (perfil == "" || perfil == null) {
            filterSelect = ["Holding", "Empresas", "Gerencias"];
        }
        if (perfil == 1){
            filterSelect = ["Empresas", "Gerencias"];
        }

        if (perfil == 2){
            filterSelect = [ "Gerencias"];
        }
        var columns = [
            {
                "data": "foto", "title": "Avatar",
                "render": function (data, row) {
                    if (!data)
                        return "";
                    if (!data.startsWith("http")) {
                        data = base_logos + "/" + data;
                    }
                    return `<img class="rounded-circle" style="width:85px;height:85px;" alt="avatar" src="${data}">`;
                }
            },
            
            {"data": "holding_id", "title": "Holding ID","orderable": false, visible: false},
            {"data": "empresa_id", "title": "Empresa","orderable": false, visible:false},
            {"data": "rut", "title": "Rut"},
            
            {"data": "gerencia_id", "title": "Gerencia ID","orderable": false, visible: false}, 
            {"data": "name", "title": "Nombre"},   
            {"data": "apellido", "title": "Apellido"},
            {"data": "email", "title": "Email"},
            {
                "data": "id", "title": "Acciones",
                "render": function (data, row) {
                    let show = "{{route("$resource.show",["_id"])}}".replace("_id", data);
                    let edit = "{{route("$resource.edit",["_id"])}}".replace("_id", data);
                    let perfil = "{!! route('perfil') !!}"+"?id="+data;
                    let style="display: {{( auth()->user()->perfil > 3)?'none':'block'}};"
                    return `
                    <div class="btn-group">
                    <a style="display: {{( auth()->user()->perfil > 3)?'none':'block'}};" class="btn btn-primary" data-id="${data}" href="${show}">
                        <i class="fa fa-search"></i>
                    </a>
                    <a style="display: {{( auth()->user()->perfil > 3)?'none':'block'}};" class="btn btn-warning white-color" data-id="${data}" href="${edit}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button style="display: {{( auth()->user()->perfil > 3)?'none':'block'}};" class="btn btn-danger" data-id="${data}">
                        <i class="fa fa-times"></i>
                    </button>
                    <a class="btn btn-primary" data-id="${data}" href="${perfil}">
                        Perfil
                    </a>
                </div>
                
                `;
                }
            },
        ];
    </script>
@endsection

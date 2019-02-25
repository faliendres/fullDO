@extends("layouts.general")
@section("page_styles")
    <link rel="stylesheet" href="{{asset("OrgChart-master/demo/css/jquery.orgchart.css")}}">
    <style>
        .orgchart {
            background: white;
        }

        #chart-container {
            /*position: relative;*/
            display: inline-block;
            top: 10px;
            left: 10px;
            height: 100%;
            width: 100%;
            border-radius: 5px;
            overflow: auto;
            text-align: center;
        }

        .nombre {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            height: 20px;
            line-height: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            background-color: rgba(225, 31, 38, 1);
            color: #fff;
        }

        .cargo {
            font-size: 10px;
            color: #1D0D89;
            font-weight: bold;
        }

        .departamento {
            font-size: 10px;
            color: #1D0D89;
        }

        .perfil {
            border-radius: 4px 4px 0 0;
        }
    </style>
@endsection

@section("content")
    <!--  All Content  -->
    <div class="row" style="margin-bottom: 1em;display:none;">
        <div class="col-md-4">
            <label>Seleccione holding</label>
            <select class="form-control" name="holdings" id="holdings">
                <option>Seleccione...</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Seleccione empresa</label>
            <select class="form-control" name="empresas" id="empresas" disabled>
                <option>Seleccione...</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Seleccione gerencia</label>
            <select class="form-control" name="gerencias" id="gerencias" disabled>
                <option>Seleccione...</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3 class="nombre-empresa"></h3>       
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="chart-container"></div>
        </div>
    </div>
    <!--  /All Contente -->
    <div class="clearfix"></div>

    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Actualice su contraseña</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{url('chempionleague')}}" id="form">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-10 ml-4">
                                <label for="Name">Contraseña:</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10 ml-4">
                                <label for="Club">Confirmar contraseña:</label>
                                <input type="password" class="form-control" name="repassword" id="repassword">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                    <button  class="btn btn-success" id="ajaxSubmit">Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section("page_scripts")
    <script type="text/javascript" src="{{asset("OrgChart-master/demo/js/jquery.orgchart.js")}}"></script>
    <script type="text/javascript">
        jQuery(function () {

            // LLenar los select
            jQuery.ajax({
                type: "GET",
                url: "/holdings",
                beforeSend: function () {
                    jQuery("#empresas").attr("disabled");
                    jQuery("#gerencias").attr("disabled");
                },
                success: function (result) {
                    let options = '';
                    Object.values(result.data).forEach( k =>{
                        options += `<option value="${k.id}">${k.nombre}</option>`;
                    });
                    jQuery("#holdings").append(options);
                }
            });

            jQuery(document).on('change','#holdings',function(){
                let holding = jQuery(this).find("option:selected").attr('value');
                let route = "{{route("getEmpresasByHolding",["_id"])}}".replace("_id", holding);
                jQuery.ajax({
                    type: "GET",
                    url: route,
                    beforeSend: function () {
                        jQuery("#empresas").empty();
                        jQuery("#empresas").attr("disabled");
                        jQuery("#empresas").append(`<option>Seleccione...</option>`);
                    },
                    success: function (result) {
                        let options = '';
                        Object.keys(result).forEach( k =>{
                            options += `<option value="${k}">${result[k]}</option>`;
                        });
                        jQuery("#empresas").append(options);
                        jQuery("#empresas").removeAttr( "disabled" );
                    }
                });
            });

            jQuery(document).on('change','#empresas',function(){
                let empresa = jQuery(this).find("option:selected").attr('value');
                let route = "{{route("getGerenciasbyEmpresa",["_id"])}}".replace("_id", empresa);
                jQuery.ajax({
                    type: "GET",
                    url: route,
                    beforeSend: function () {
                        jQuery("#gerencias").empty();
                        jQuery("#gerencias").attr("disabled");
                        jQuery("#gerencias").append(`<option>Seleccione...</option>`);
                    },
                    success: function (result) {
                        let options = '';
                        Object.keys(result).forEach( k =>{
                            options += `<option value="${k}">${result[k]}</option>`;
                        });
                        jQuery("#gerencias").append(options);
                        jQuery("#gerencias").removeAttr( "disabled" );
                    }
                });
            });

            let datasource;
            jQuery.ajax({
                type: "GET",
                url: "{{route("getEstructura")}}",
                beforeSend: function () {
                },
                success: function (result) {
                    datasource = result;
                    var nodeTemplate = function (data) {
                        let link;
                        if(data.id=='-1'){
                            link = "#";
                        }else{
                            link = `perfil?id=${data.id}`;
                        }
                        return `<a href="${link}">
                                    <img class="perfil" src="images/avatar/${data.avatar}" width="65px" height="65px;" />
                                    <div class="nombre" style="border-radius:unset !important;">${data.name}</div>
                                    <div class="cargo">${data.title}</div>
                                    <div class="departamento">${data.office}</div>
                                </a>
                              `;
                    };

                    var oc = jQuery('#chart-container').orgchart({
                        'data': datasource,
                        'nodeTemplate': nodeTemplate,
                        'pan': true,
                        //'zoom': true
                        //'visibleLevel': 2
                    });
                }
            });
            let url = "{{route("gerencias.show",["_id"])}}".replace("_id", 1);
            jQuery.ajax({
                type: "GET",
                url: url,
                beforeSend: function () { },
                success: function (result) {
                    url = "{{route("empresas.show",["_id"])}}".replace("_id", result.id_empresa);
                    jQuery.ajax({
                        type: "GET",
                        url: url,
                        beforeSend: function () { },
                        success: function (response) {
                            $(".nombre-empresa").html(response.nombre);
                        }
                    });

                }
            });



        // change password
        var fecha = "{{ Auth::user()->password_changed_at }}";
        if( fecha == ""){
            $("#myModal").modal('show');
        }

            jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                jQuery('.alert-danger').html('');
                if(jQuery('#password').val() != "" && jQuery('#repassword').val() != ""){
                    if(jQuery('#password').val() == jQuery('#repassword').val() ){
                        jQuery('.alert-danger').hide();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }
                        });
                        jQuery.ajax({
                            url: "{{ route('users.changepassword') }}",
                            method: 'post',
                            data: {
                                password: jQuery('#password').val(),
                                repassword: jQuery('#repassword').val(),
                            },
                            success: function(result){

                                $('#myModal').modal('hide');
                            }});
                    }else{
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<li>Las contraseñas deben coincidir</li>');
                    }
                }else{
                    jQuery('.alert-danger').show();
                    jQuery('.alert-danger').append('<li>Rellene todos los campos</li>');
                }

            });

        });
    </script>
@endsection

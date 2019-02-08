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
        <div class="col-lg-12 col-md-12">
            <div id="chart-container"></div>
        </div>
    </div>
    <!--  /All Contente -->
    <div class="clearfix"></div>
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
                        return `
                                <img class="perfil" src="images/avatar/${data.avatar}" width="65px" height="65px;" />
                                <div class="nombre" style="border-radius:unset !important;">${data.name}</div>
                                <div class="cargo">${data.title}</div>
                                <div class="departamento">${data.office}</div>
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

        });
    </script>
@endsection
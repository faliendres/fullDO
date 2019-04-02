@extends("layouts.general")
@section("page_styles")
    <link rel="stylesheet" href="{{asset("OrgChart-master/demo/css/jquery.orgchart.css")}}">
    <style>
        .orgchart {
            background: white;
        }
        #chart-container {
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
        .dotacion{
            font-size: 8px;
            color: #1D0D89;
        }
        .oc-export-btn, .oc-export-btn:active, .oc-export-btn:hover, .oc-export-btn:focus{
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .orgchart .nombre { background-color: #006699; }
    </style>
@endsection

@section("content")
    <!--  All Content  -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="chart-container">
            </div>
            <div class="row" id="buttons-zoom" style="margin-top: 15px;">
                <div class="col-lg-12 col-md-12 text-center">ZOOM
                    <button  class="btn btn-primary chartzoomin" ><i class="fa fa-plus"></i></button>
                    <button  class="btn btn-primary chartzoomout"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!--  /All Contente -->
    <div class="clearfix"></div>

@endsection


@section("page_scripts")
    <script type="text/javascript" src="{{asset("OrgChart-master/demo/js/jquery.orgchart.js")}}"></script>
    <script type="text/javascript">
        jQuery(function () {
            let datasource;
            const urlParams = new URLSearchParams(window.location.search);
            const myParam = urlParams.get('id');
            let treeUrl = "{{route("getEstructura") . '?e=' . Auth::user()->empresa_id }}" + '&id='+ urlParams.get('id') ;
            jQuery.ajax({
                type: "GET",
                url: treeUrl,
                beforeSend: function () {
                },
                success: function (result) {
                    datasource = result;
                    var nodeTemplate = function (data) {
                        let link;
                        if(data.id=='-1'){
                            link = "#";
                        }else{
                            link = "{!! route('perfil') !!}"+"?id="+data.id;
                        }
                        return `<a href="${link}" >
                                    <img class="perfil" src="images/avatar/${data.avatar}" width="65px" height="65px;" />
                                    <div class="nombre" style="color:black;border-radius:unset !important;background-color:${data.color} !important;">${data.name}</div>
                                    <div class="cargo">${data.title}</div>
                                    <div class="departamento">${data.office}</div>
                                    <div class="dotacion">${data.dotacion}</div>
                                </a>
                              `;
                    };

                    var oc = jQuery('#chart-container').orgchart({
                        'data': datasource,
                        'nodeTemplate': nodeTemplate,
                        'pan': true,
                        'exportButton': true,
                        'exportFileextension': 'pdf',
                        'exportFilename': 'organigrama',
                        'visibleLevel': 4,
                        'initCompleted': function(){
                            setTimeout( function(){
                                // center the chart to container
                                var $container = $('#chart-container');
                                $container.scrollLeft(($container[0].scrollWidth - $container.width())/2);
                                // get "zoom" and make usable
                                var $chart = $('.orgchart');
                                $chart.css('transform', "scale(1,1)");
                                var div = $chart.css('transform');
                                var values = div.split('(')[1];
                                values = values.split(')')[0];
                                values = values.split(',');
                                var a = values[0];
                                var b = values[1];
                                var currentZoom = Math.sqrt(a*a + b*b);
                                var zoomval = .8;

                                // zoom buttons
                                $('.chartzoomin').on('click', function () {
                                    zoomval = currentZoom += 0.1;
                                    $chart.css('transform', div+" scale(" + zoomval + "," + zoomval + ")");
                                });
                                $('.chartzoomout').on('click', function () {
                                    if(currentZoom > 0.2){
                                            zoomval = currentZoom -= 0.1;
                                            $chart.css('transform', div+" scale(" + zoomval + "," + zoomval + ")");
                                    }
                                });
                            }  , 1000 );
                        }
                    });
                }
            });
            var base_logos="{{image_asset('empresas')}}";
            var empresa_id = "{{Auth::user()->empresa_id}}" ? "{{Auth::user()->empresa_id}}" : 1;
            url = "{{route("empresas.show",["_id"])}}".replace("_id", empresa_id);
            jQuery.ajax({
                type: "GET",
                url: url,
                beforeSend: function () { },
                success: function (response) {
                    if(!response.logo)
                        response.logo="nologo.png"
                    if (!(response.logo).startsWith("http"))
                        response.logo=base_logos+"/"+response.logo;                           
                    //$(".logo-empresa").html('<img class="rounded-circle" style="width:85px;height:85px;margin: 15px;" alt="logo" src="'+response.logo+'">'); 
                }
            });
        });
    </script>
@endsection

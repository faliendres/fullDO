@extends("layouts.app")
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

            var datasource = {
                'avatar': 'admin.jpg',
                'name': 'John Doe',
                'title': 'Gerente General',
                'office': 'Gerencia General',
                'children': [
                    {
                        'avatar': '2.jpg',
                        'name': 'John Smith',
                        'title': 'Gerente Comercial',
                        'office': 'Gerencia Comercial'
                    },
                    {
                        'avatar': '3.jpg', 'name': 'John Neo', 'title': 'Gerente TI', 'office': 'TI',
                        'children': [
                            {'avatar': '4.jpg', 'name': 'John Hua', 'title': 'Ingeniero Experto', 'office': 'TI'},
                            {'avatar': '5.jpg', 'name': 'John Hei', 'title': 'Ingeniero Experto', 'office': 'TI'}
                        ]
                    },
                    {'avatar': '6.jpg', 'name': 'John Jie', 'title': 'Gerente Finanzas', 'office': 'Finanzas'},
                    {'avatar': '64-1.jpg', 'name': 'John Li', 'title': 'Gerente RRHH', 'office': 'Recursos Humanos'},
                    {
                        'avatar': '64-2.jpg',
                        'name': 'John Miao',
                        'title': 'Gerente Administración',
                        'office': 'Administración'
                    },
                    {'avatar': '1.jpg', 'name': 'John Lee', 'title': 'Gerente Riesgo', 'office': 'Riesgo'}
                    /*{ 'name': 'Yu Wei', 'title': 'department manager', 'office': '长春' },
                    { 'name': 'Chun Miao', 'title': 'department manager', 'office': '长春' },
                    { 'name': 'Yu Tie', 'title': 'department manager', 'office': '长春' }*/
                ]
            };

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

        });
    </script>
@endsection
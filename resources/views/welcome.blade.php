<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FullDO - Laravel</title>
    <meta name="description" content="FullDO - Demo">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset("favicon.ico")}}" type="image/x-icon">
    <link rel="icon" href="{{asset("favicon.ico")}}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset("assets/css/cs-skin-elastic.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("OrgChart-master/demo/css/jquery.orgchart.css")}}">
</head>
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
<body>
<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="index.html"><i class="menu-icon fa fa-laptop"></i>Demo </a>
                </li>
                <li class="menu-title">Menu 1</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Submenu 1</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-puzzle-piece"></i><a href="#">Extra 1</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="#">Extra 2</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Submenu 2</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-table"></i><a href="#">Extra 1</a></li>
                        <li><i class="fa fa-table"></i><a href="#">Extra 2</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Submenu 3</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-th"></i><a href="#">Extra 1</a></li>
                        <li><i class="menu-icon fa fa-th"></i><a href="#">Extra 2</a></li>
                    </ul>
                </li>

                <li class="menu-title">Menu 2</li><!-- /.menu-title -->

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Submenu 1</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-fort-awesome"></i><a href="#">Extra 1</a></li>
                        <li><i class="menu-icon ti-themify-logo"></i><a href="#">Extra 2</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"> <i class="menu-icon ti-email"></i>Submenu 2 </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="./"><img src="images/logofulldo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="images/logofulldo.png" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">
                <div class="header-left">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <img class="user-avatar rounded-circle"
                                 src="https://i0.wp.com/tricksmaze.com/wp-content/uploads/2017/04/Stylish-Girls-Profile-Pictures-36.jpg?resize=300%2C300&ssl=1"
                                 alt="User Avatar">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="{{route("profile")}}"><i class="fa fa- user"></i>Perfil</a>
                            <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /#header -->
    <!-- Content -->
    <div class="content">
        <!--  All Content  -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div id="chart-container"></div>
            </div>
        </div>
        <!--  /All Contente -->
        <div class="clearfix"></div>
    </div>
    <!-- /.content -->
    <div class="clearfix"></div>
    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner bg-white">
            <div class="row">
                <div class="col-sm-6">
                    FullDO Demo
                </div>
                <div class="col-sm-6 text-right">
                    Desarrollado por <a href="https://www.amistek.cl">Amistek</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- /.site-footer -->
</div>
<!-- /#right-panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>
<script type="text/javascript" src="OrgChart-master/demo/js/jquery.orgchart.js"></script>
<script type="text/javascript">
    jQuery(function () {

        var datasource = {
            'avatar': 'admin.jpg',
            'name': 'John Doe',
            'title': 'Gerente General',
            'office': 'Gerencia General',
            'children': [
                {'avatar': '2.jpg', 'name': 'John Smith', 'title': 'Gerente Comercial', 'office': 'Gerencia Comercial'},
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
</body>
</html>

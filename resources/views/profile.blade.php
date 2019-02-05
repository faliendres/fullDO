@extends("layouts.general")
@section("page_styles")
    <style>
        .emp-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            width: 70%;
            height: 100%;
        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #1D0D89;
        }

        .profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .proile-rating {
            font-size: 12px;
            color: #818182;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #1D0D89;
        }

        .profile-work {
            padding: 14%;
            margin-top: -15%;
        }

        .profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-work a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work ul {
            list-style: none;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #1D0D89;
        }
    </style>
@endsection
<!-- Content -->
@section("content")
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="https://i0.wp.com/tricksmaze.com/wp-content/uploads/2017/04/Stylish-Girls-Profile-Pictures-36.jpg?resize=400%2C300&ssl=1"
                             alt=""/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h4>Juana Pérez</h4>
                        <h5>Subgerente Comercial</h5>
                        <h6>Gerencia Comercial</h6>
                        <p class="proile-rating">Jefatura: Enrique Henriquez<br/>
                            Comenzó a trabajar el 24 de Diciembre de 2012</p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                   role="tab" aria-controls="profile" aria-selected="true">Funciones del Cargo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="false">Contacto</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab"
                                   aria-controls="report" aria-selected="false">Reportes Directos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>Datos adicionales</p>
                        <a href="#">Perfil del Cargo</a><br/>
                        <a href="#">Link opcional</a><br/>
                        <a href="#">Link opcional</a><br/>
                        <p>Datos adicionales</p>
                        <a href="#">Link opcional</a><br/>
                        <a href="#">Link opcional</a><br/>
                        <a href="#">Link opcional</a><br/>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Celular</label>
                                </div>
                                <div class="col-md-6">
                                    <p>+569 9554 64 46</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>juana@empresa.cl</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Anexo</label>
                                </div>
                                <div class="col-md-6">
                                    <p>123 456 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="profile" role="tabpanel"
                             aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra
                                        eleifend nibh, vitae interdum nulla. Donec ac ipsum at eros lacinia aliquet.
                                        Ut lobortis neque id odio tincidunt egestas. Suspendisse auctor porta nunc
                                        ac dictum. Vestibulum porttitor nisi eget ante laoreet pretium. Aenean in
                                        elementum neque. Praesent condimentum maximus neque. Nullam viverra vitae
                                        lorem ac auctor. Fusce ante felis, semper at consequat facilisis, mollis sed
                                        eros. Integer condimentum convallis lorem, semper ornare nulla hendrerit
                                        eget. Suspendisse viverra nisl quis tortor posuere, vel auctor tellus
                                        ornare. Integer nec metus ac dolor iaculis elementum. Fusce ut elementum
                                        arcu, at semper enim. Donec imperdiet et nunc nec vehicula.</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Carlos Guzmán</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Jefe de Ventas</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Rosa Carmona</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Subgerente de Marketing</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Pedro Pablo</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Supervisor de Ventas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
<!-- /.content -->

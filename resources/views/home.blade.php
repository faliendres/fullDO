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
        .oc-export-btn, .oc-export-btn:active, .oc-export-btn:hover, .oc-export-btn:focus{
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endsection

@section("content")
    <!--  All Content  -->
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <div id="banner-container"></div>
        </div>
    </div>

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

        var base_banners="{{image_asset('empresas')}}";
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
                        if(!response.banner)
                            response.banner="nobanner.png"
                        if (!(response.banner).startsWith("http"))
                            response.banner=base_banners+"/"+response.banner;                           
                        $("#banner-container").html('<img alt="banner" src='+response.banner+'>');
                        
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

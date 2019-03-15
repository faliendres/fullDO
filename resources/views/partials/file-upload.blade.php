@php
    $auxId=uniqid($name);
    if(isset($instance->$name))
    $value=$instance->$name;
$multiple=isset($multiple)&&$multiple
@endphp
<div class="row form-group">
    <div class="col col-md-3">
        <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
    </div>
    @if(!(isset($readonly)&&$readonly))
        <div class="col-12 col-md-9">
            <div class="container">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Agregar Archivos...</span>
                    <!-- The file input field used as target for the file upload widget -->
                     <input id="fileupload{{$auxId}}" type="file" name="{{$name}}_file[]" multiple>
                </span>
                <br>
                <br>
                <!-- The global progress bar -->
                <div id="progress" class="progress my-3">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <!-- The container for the uploaded files -->
                <div id="{{$auxId}}" class="files row col-12"></div>
            </div>


        </div>
    @endif
    @if(isset($value)&&$value)
        <input  id="file_{{$auxId}}"  type="hidden" name="{{$name}}" value="{{$value}}">
        <ul class="col-12 col-md-9 offset-md-3" id="list_{{$auxId}}" data-target="{{$name}}">
            @foreach(json_decode($value,true) as  $item)
                <li data-content="{{$item}}">
                    <a href="{{image_asset($resource,$item)}}" target="_blank">{{$item}}</a>
                    @if(!(isset($readonly)&&$readonly))
                        <a href="#" class="text-danger" onclick="clean(this)"><i class="fa fa-times"></i></a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>



@section("page_styles")
    <!-- Bootstrap styles -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <!-- Generic page styles -->
    <link rel="stylesheet" href="{{asset("jquery-file-upload/css/style.css")}}"/>
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{asset("jquery-file-upload/css/jquery.fileupload.css")}}"/>
@endsection

<script>
@if(!(isset($readonly)&&$readonly))
    let readonly{{$auxId}} = true;
            @else
    let readonly{{$auxId}} = false;
@endif


function clean(element) {
    if ($) {
        let $element = $(element);
        let $ul = $element.closest("ul[data-target]");
        let $li = $element.closest("li[data-content]");
        let content = $li.data("content");
        let target = $ul.data("target");
        let $input = $(`#file_{{$auxId}}`);
        let res = JSON.parse($input.val());
        res = res.filter(e => e !== content);
        $input.val(JSON.stringify(res));
        $li.remove();
    }
}
</script>
<script>
    (() => {

        document.addEventListener("DOMContentLoaded", function (event) {
            //do work
            let f{{$auxId}};
            /*jslint unparam: true, regexp: true */
            /*global window, $ */
            $(function () {
                'use strict';
                // Change this to the location of your server-side upload handler:
                let url = '{{route("$resource.upload",["id"=>isset($instance)?$instance->id:"_new"])}}';

                f{{$auxId}} = $('#fileupload{{$auxId}}').fileupload({
                    url: url,
                    dataType: 'json',
                    // autoUpload: false,
                    maxFileSize: 999000,

                }).on('fileuploadadd', function (e, data) {
                    data.context = $('<div class="col-lg-3 col-md-4"/>').appendTo('#{{$auxId}}');
                    $.each(data.files, function (index, file) {
                        let node = $('<p/>')
                            .append($('<span/>').text(file.name));
                        node.appendTo(data.context);
                    });
                }).on('fileuploadprocessalways', function (e, data) {
                    let index = data.index,
                        file = data.files[index],
                        node = $(data.context.children()[index]);
                    if (file.preview) {
                        node
                            .prepend('<br>')
                            .prepend(file.preview);
                    }
                    if (file.error) {
                        node
                            .append('<br>')
                            .append($('<span class="text-danger"/>').text(file.error));
                        node.find("button").remove();
                        let $deleteme = $("<button type='button' href='#' class='btn btn-danger'/>");
                        $deleteme.append($("<i class='fa fa-times'/>"));
                        $deleteme.click(function (event) {
                            e.preventDefault();
                            node.closest("div").remove();
                        });
                        node.append('<br>').append($deleteme);
                    }
                    if (index + 1 === data.files.length) {
                        data.context.find('button:not(.btn-danger)')
                            .text('Upload')
                            .prop('disabled', !!data.files.error);
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    let progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }).on('fileuploaddone', function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        if (file.url) {

                            let $input = $(`#file_{{$auxId}}`);
                            let res = JSON.parse($input.val());
                            res.push(file.url);
                            $input.val(JSON.stringify(res));

                            let li = $("<li>")
                            .attr('data-content', file.url);
                            li.append($('<a>')
                                .attr('target', '_blank')
                                .prop('href', file.url)
                                .text(file.url));
                            if (readonly{{$auxId}}) {
                                li.append('<a href="#" class="text-danger" onclick="clean(this)"><i class="fa fa-times"></i></a>');
                            }

                            $(data.context).remove();

                            $("#list_{{$auxId}}").append(li);


                        } else if (file.error) {
                            let error = $('<span class="text-danger"/>').text(file.error);
                            let node = $(data.context.children()[index]);
                            node
                                .append('<br>')
                                .append(error);
                            let $deleteme = $("<button type='button' href='#' class='btn btn-danger'/>");
                            $deleteme.append($("<i class='fa fa-times'/>"));
                            $deleteme.click(function (event) {
                                e.preventDefault();
                                node.closest("div").remove();
                            });
                            node.append('<br>').append($deleteme);


                        }
                    });
                }).on('fileuploadfail', function (e, data) {
                    $.each(data.files, function (index) {
                        let error = $('<span class="text-danger"/>').text('File upload failed.');
                        let node = $(data.context.children()[index]);
                        node
                            .append('<br>')
                            .append(error);
                        let $deleteme = $("<button type='button' href='#' class='btn btn-danger'/>");
                        $deleteme.append($("<i class='fa fa-times'/>"));
                        $deleteme.click(function (event) {
                            e.preventDefault();
                            node.closest("div").remove();
                        });
                        node.append('<br>').append($deleteme);
                    });
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        });

    })();


</script>

@section("page_scripts")
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="{{ asset('jquery-file-upload/js/vendor/jquery.ui.widget.js')}}"></script>
    {{--<!-- The Load Image plugin is included for the preview images and image resizing functionality -->--}}
    <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{ asset('jquery-file-upload/js/jquery.iframe-transport.js')}}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload.js')}}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload-process.js')}}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload-image.js')}}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload-audio.js')}}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload-video.js')}}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{ asset('jquery-file-upload/js/jquery.fileupload-validate.js')}}"></script>
@endsection
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
            @if(isset($rename)&&$rename)
                <input type="hidden" name="{{$name}}_rename" value="true">
            @endif


            <input type="file" id="{{$auxId}}" {{$multiple?"multiple":""}} name="{{$name}}_file{{$multiple?"[]":""}}"
                   {{($required??false)?"required":""}}  class="form-control-file">
            @if ($errors->has("$name"))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("$name") }}</strong>
                </span>
            @endif
        </div>


    @endif
    @if(isset($value)&&$value)
        <input type="hidden" name="{{$name}}" value="{{$value}}">
        <ul class="col-12 col-md-9 offset-md-3" data-target="{{$name}}">
            @foreach(explode("/",$value) as $item)
                <li data-content="{{$item}}">
                    <a href="{{image_asset($resource,$item)}}" target="_blank">{{ isset($mascara) ? $mascara : $item}}</a>
                    @if(!(isset($readonly)&&$readonly))
                        <a href="#" class="text-danger" onclick="clean(this)"><i class="fa fa-times"></i></a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
<script>
    function clean(element) {
        if ($) {
            let $element = $(element);
            let $ul = $element.closest("ul[data-target]");
            let $li = $element.closest("li[data-content]");
            let content = $li.data("content");
            let target = $ul.data("target");
            let $input = $(`input[name="${target}"]`);
            let res = $input.val().replace(`${content}`, "");
            res = res.replace("//", "/");
            if (res.startsWith("/"))
                res = res.substring(1);
            if (res.endsWith("/"))
                res = res.substring(0, res.length - 1);
            $input.val(res);
            $li.remove();
        }
    }
</script>

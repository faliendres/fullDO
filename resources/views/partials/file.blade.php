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
        <input type="hidden" name="{{$name}}">
        <ul data-target="{{$name}}">
        @foreach(explode("/",$value) as $item)
        <li>
            <a href="{{image_asset($resource,$item)}}" target="_blank">{{$item}}</a>
            @if(!(isset($readonly)&&$readonly))
                <a class="text-danger"><i class="fa fa-times"></i></a>
            @endif
        </li>
        @endforeach
        </ul>
    @endif
</div>

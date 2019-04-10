@php
    $auxId=uniqid($name);
    if(!isset($value)||!$value)
        $value=$instance->$name??"";
@endphp
@if(isset($readonly)&&$readonly)
    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
        </div>
        <div class="col-12 col-md-9">
            <h4 class="form-control-plaintext">{{$value?"Activo":"Inactivo"}}</h4>
        </div>
    </div>
@else
    @if(($type??"")=="hidden")
        <input type="hidden" name="{{$name}}" value="{{$value??""}}">
    @else
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
            </div>
            <div class="col-12 col-md-9">
                <label   class="switch">
                <input type="{{$type??"checkbox"}}" id="{{$auxId}}" name="{{$name}}"
                       {{($required??false)?"required":""}} placeholder="{{$placeholder??""}}"
                       class="switch form-control{{ $errors->has("$name") ? ' is-invalid' : '' }}" value="1" {{$value==1?"checked":""}}>
                <span class="slider"></span>
                </label>
                @if ($errors->has("$name"))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("$name") }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif
@endif



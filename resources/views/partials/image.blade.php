@php
    $auxId=uniqid($name);
    if(!isset($value)||!$value)
      $value=$instance->$name??"";
@endphp


@if(($type??"")=="hidden")
    <input type="hidden" name="{{$name}}" value="{{$value??""}}">
@else
    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
        </div>
        @if(!(isset($readonly)&&$readonly))
            <div class="col-12 col-md-9">
                <input type="file" id="{{$auxId}}" name="{{$name}}_file"
                       {{($required??false)?"required":""}}
                       accept="image/*" class="form-control-file">
                @if ($errors->has("$name"))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("$name") }}</strong>
                    </span>
                @endif
            </div>
            <div class="col col-md-3"></div>

        @endif
        @if($value)
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="{{image_asset($resource,$value)}}" id="{{$auxId}}" alt="{{$name}}">
                </div>
            </div>
        @endif
    </div>
@endif
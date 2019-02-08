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
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="{{asset("/images/avatar/$value")}}" id="{{$auxId}}" alt="foto" >
                </div>
            </div>
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
                <input type="file" id="{{$auxId}}" name="{{$name}}_file"
                       {{($required??false)?"required":""}}
                       accept="image/*" class="form-control-file">
                <small class="form-text text-muted">{{$help??""}}</small>
            </div>
        </div>
    @endif
@endif
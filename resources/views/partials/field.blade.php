@php
    $auxId=uniqid($name)
@endphp
@if(($type??"")=="hidden")
    <input type="hidden" name="{{$name}}" value="{{$value??""}}">
@else
    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
        </div>
        <div class="col-12 col-md-9">
            <input type="{{$type??"text"}}" id="{{$auxId}}" name="{{$name}}" value="{{$value??""}}"
                   {{($required??false)?"required":""}} placeholder="{{$placeholder??""}}" class="form-control">
            <small class="form-text text-muted">{{$help??""}}</small>
        </div>
    </div>
@endif
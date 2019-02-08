@php
    $auxId=uniqid($name)
@endphp

@if($stable)
    <div class="row form-group">
        <div class="col col-md-3">
            <label class="form-control-label">{{$title??""}}</label>
        </div>
        <div class="col-12 col-md-9">
            <h4>{{$options->first()["text"]}}</h4>
        </div>
    </div>
    @include("partials.field",["name"=>$name,"type"=>"hidden","value"=>$options->first()["id"]])
@else

    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label">{{$title??""}}</label></div>
        <div class="col-12 col-md-9">
            <select name="{{$name}}" id="{{$auxId}}" {{($required??false)?"required":""}} class="form-control-lg form-control">
                @if(count($options)>1)
                <option selected value="" disabled>Seleccione por favor</option>
                @endif
                @foreach($options as $option)
                    <option value="{{$option["id"]}}"
                            {{$option["selected"]}}>
                        {{$option["text"]}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endif












@php
    $auxId=uniqid($name);
    $value=isset($instance->$name);

    if(!isset($selected)||!$selected){
        $selected=collect($options)->filter(function($item)use($value){
           return $value==$item["id"];
        });

    }
    $selected=$selected->first();
    if(!$selected)
            $selected["text"]=$value;
@endphp
@if(isset($readonly)&&$readonly)
    <div class="row form-group">
        <div class="col col-md-3">
            <label for="{{$auxId}}" class=" form-control-label"> {{$title??""}}</label>
        </div>
        <div class="col-12 col-md-9">
            <h4 class="form-control-plaintext">{{$selected["text"]??""}}</h4>
        </div>
    </div>
@else
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
                <select name="{{$name}}" id="{{$auxId}}"
                        {{($required??false)?"required":""}} class="form-control-lg form-control {{ $errors->has("$name") ? ' is-invalid' : '' }}">
                    @if(count($options)>1)
                        <option selected value="" disabled>Seleccione por favor</option>
                    @endif
                    @foreach($options as $option)
                        <option value="{{$option["id"]}}"
                                {{($value==$option["id"])?"selected":""}}>
                            {{$option["text"]}}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has("$name"))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("$name") }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif
@endif












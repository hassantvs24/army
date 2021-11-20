<div class="input-group mb-15">
    @if(isset($addon))
        <span class="input-group-addon">{{$addon}}</span>
    @endif
    <input id="{{$id ?? ''}}" name="{{$name ?? ''}}" type="{{$type ?? 'text'}}" class="form-control {{$class ?? ''}}"  placeholder="{{$label ?? ''}}" value="{{$value ?? ''}}" {{$rest ?? ''}} @if($required == 'required') required @endif />
    @if(isset($btn))
        <span class="input-group-btn">
            {{$btn}}
        </span>
    @endif
</div>
@error($name)
<span class="help-block">{{ $message }}</span>
@enderror
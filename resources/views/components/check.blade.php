<div class="form-group">
    <div class="checkbox">
        <label>
            <input name="{{$name ?? ''}}" class="{{$class ?? ''}}" value="{{$value ?? ''}}" type="checkbox"  @if(isset($required))<span class="text-danger">*</span>@endif @if(isset($checked)) checked="checked"@endif>
            {{$label ?? ''}}
        </label>
    </div>
</div>
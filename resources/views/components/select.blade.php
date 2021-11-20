<div class="form-group @error($name)has-error @enderror">
    @php
        $set_id = $id ??  mt_rand();
    @endphp
    <label for="{{$set_id}}" class="control-label col-lg-3">{{$label ?? ''}} @if($required == 'required')<span class="text-danger">*</span>@endif</label>
    <div class="col-lg-9">
        <select id="{{$set_id}}" name="{{$name ?? ''}}" class="form-control {{$class ?? ''}}"  {{$rest ?? ''}} @if($required == 'required') required @endif >
            {{$slot}}
        </select>

        @error($name)
            <span class="help-block">{{$message}}</span>
        @enderror

    </div>
</div>
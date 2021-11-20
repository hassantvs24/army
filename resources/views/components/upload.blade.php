<div class="form-group @error($name)has-error @enderror">
    @php
        $set_id = $id ??  mt_rand();
    @endphp
    <label for="{{$set_id}}" class="control-label col-lg-3">{{$label ?? ''}} @if($required == 'required')<span class="text-danger">*</span>@endif</label>
    <div class="col-lg-9">
        <input id="{{$set_id}}" name="{{$name ?? ''}}" type="file" class="form-control is-invalid"  placeholder="{{$label ?? ''}}" accept="{{$accept ?? ''}}" {{$rest ?? ''}} @if($required == 'required') required @endif />

        @error($name)
            <span class="help-block">{{$message}}</span>
        @enderror

    </div>
</div>
@if(isset($header))
<div class="row mb-15">
    <div class="col-sm-12"><h5 class="text-center"><strong>{{$header}}</strong></h5></div>
</div>
@endif

@if(isset($sub) || isset($subr))
    <div class="row mb-15">
        <div class="col-sm-6">{{$sub ?? ''}}</div>
        <div class="col-sm-6 text-right">{{$subr ?? ''}}</div>
    </div>
@endif
<div class="row">
    <div class="col-sm-12">
        {{$slot}}
    </div>
</div>

<div class="panel panel-default">
    @if(isset($name))
        <div class="panel-heading">
            <h5 class="panel-title"><i class="icon-shutter text-info"></i> {{ $name ?? '' }}</h5>
        </div>
    @endif

    <div class="panel-body">
        {{$slot}}
    </div>

</div>

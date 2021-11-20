<div class="panel panel-default">
    @if(isset($name))
        <div class="panel-heading">
            <h5 class="panel-title"><i class="icon-shutter text-info position-left"></i> {{ $name ?? '' }}</h5>
            @if(isset($header))
                <div class="heading-elements">
                    {{$header}}
                </div>
            @endif

        </div>

    @endif

    <div class="panel-body"></div>

    <div class="table-responsive" style="overflow-x: inherit;">
        {{ $slot }}
    </div>

</div>

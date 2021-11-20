<div class="panel panel-default">
    @if(isset($name))
        <div class="panel-heading">
            <h5 class="panel-title"><i class="icon-shutter text-info position-left"></i> {{ $name ?? '' }}</h5>
            @if(isset($body))
                <div class="heading-elements">
                    <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> {{$body}}</button>
                </div>
            @endif

        </div>

    @endif

    <div class="panel-body"></div>

    <div class="table-responsive" style="overflow-x: inherit;">
        {{ $slot }}
    </div>

</div>

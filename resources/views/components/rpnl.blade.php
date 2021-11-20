<div class="panel panel-flat">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-{{$icon ?? 'cog3'}} position-left"></i> {{$name ?? 'Action Panel'}}</h6>
    </div>
    @if(isset($action))
        <form action="{{$action}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        @csrf
    @endif
    <div class="panel-body">
        {{$slot}}
    </div>
    <div class="panel-footer panel-footer-transparent">
        <div class="heading-elements">
            <button type="submit" class="btn bg-indigo-400 btn-xs heading-btn pull-right btn-labeled btn-labeled-left"><b><i class="icon-checkmark4"></i></b> Submit</button>
        </div>
    </div>
    @if(isset($action))
        </form>
    @endif
</div>
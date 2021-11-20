<div id="{{$id}}" class="modal fade">
    <div class="modal-dialog {{$size}}">
        <div class="modal-content">
            @if(isset($title))
            <div class="modal-header bg-{{$bg}}">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><i class="icon-{{$icon}}"></i> {{$title}}</h5>
            </div>
            @endif
            @if(isset($action))
            <form action="{{$action}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
            @endif
                <div class="modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-labeled btn-labeled-left" data-dismiss="modal"><b><i class="icon-cancel-circle2"></i></b> Close</button>
                    <button type="submit" class="btn btn-{{$bg}} btn-labeled btn-labeled-left"><b><i class="icon-checkmark4"></i></b> Save changes</button>
                </div>
            @if(isset($action))
            </form>
            @endif
        </div>
    </div>
</div>
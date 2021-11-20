<div id="signature">
    @if(isset($left))
    <div id="authorize_signature">{{$left ?? ''}}</div><!--Authorize Signature-->
    @endif
    @if(isset($right))
        <div id="customer_signature">{{$right ?? ''}}</div><!--Customer Signature-->
    @endif
</div>
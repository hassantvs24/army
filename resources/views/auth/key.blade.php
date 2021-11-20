@extends('layouts.app')

@section('content')

    <!-- Advanced login -->
    <form  method="POST" action="{{ route('key.active') }}">
        @csrf
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-key"></i></div>
                <h5 class="content-group">Activate Your Software</h5>
            </div>

            <div class="form-group has-feedback has-feedback-left {{ $errors->has('activation_code') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Activation Code" name="activation_code" required>
                <div class="form-control-feedback">
                    <i class="icon-key text-muted"></i>
                </div>
                @if ($errors->has('activation_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('activation_code') }}</strong>
                    </span>
                @endif
            </div>

            <!--<p>{{ Auth::user()->business['software_key']}}</p>-->

            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block"><i class="icon-unlocked position-right"></i> Activate</button>
            </div>
            <p class="text-center" title="Go to dashboard"><a href="{{route('index')}}"><i class="icon-home4"></i></a></p>
        </div>
    </form>
    <!-- /advanced login -->
    <p class="text-center text-warning text-size-large text-semibold">Remaining Day: {{$remain}}</p>
    <p class="text-center text-grey-300 text-size-mini">{{ Auth::user()->business['software_key']}}</p>


@endsection

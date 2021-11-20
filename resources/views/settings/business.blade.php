@extends('layouts.master')

@section('title')
    Business
@endsection
@section('content')

    <x-panel name="Business Setup">

        <form action="{{route('business.update', ['business' => $table->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center pb-15">
                    <img src="{{$table->logo}}" class="img-rounded" alt="Business Logo">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-input name="name" label="Business Name" required="required" value="{{$table->name}}" />
                    <x-input name="proprietor" label="Proprietor Name" value="{{$table->proprietor ?? Auth::user()->name}}" required="required" />
                    <x-input name="contact" label="Contact Number" value="{{$table->contact}}" required="required" />
                    <x-input name="address" label="Address" value="{{$table->address}}" required="required" />
                    <x-input name="email" type="email" label="Email" value="{{$table->email}}" />
                </div>
                <div class="col-md-6">
                    <x-input name="contact_alternate" label="Alternate Contact" value="{{$table->contact_alternate}}" />
                    <x-input name="phone" label="Phone Number" value="{{$table->phone}}" />
                    <x-input name="website" label="Website" value="{{$table->website}}" />
                    <x-upload name="logo" label="Logo Upload" accept="image/png, image/jpeg" />

                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-labeled btn-labeled-left"><b><i class="icon-pencil6"></i></b> Update</button>
                    </div>

                </div>
            </div>
        </form>

    </x-panel>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
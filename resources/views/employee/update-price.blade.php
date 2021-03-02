@extends('adminlte::page')

@section('title', 'Customer Page')

@section('content_header')
    <h1>Update per Hour Rate</h1>
@stop

@section('content')

<div class="col-md-6 card">
    <form action=" {{ route('save-price') }} " method="POST">
        @csrf
        <div class="card-body">
            <div>
                <h5 class="p-0 m-0">Service Inclusions:</h5>
                <ul>
                    <li>Basic Cleaning</li>
                    <li>Mopping</li>
                    <li>Sweeping</li>
                    <li>Blinds and Window Sills (Dusted)</li>
                    <li>Cobwebs Removal</li>
                    <li>Lampshades Cleaning</li>
                    <li>Mirrors (Dusted)</li>
                    <li>Dusted Paintings, Pictures</li>
                    <li>Floors</li>
                    <li>CR</li>
                    <li>Appliances (Dusted)</li>
                </ul>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount" id="amount" value="{{ $price->price ?? 0 }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
    
@stop

@section('css')
    
@stop

@section('js')

  
@stop
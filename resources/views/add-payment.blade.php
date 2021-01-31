@extends('adminlte::page')

@section('title', 'Customer Page')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="card col-md-6">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                   Add Payment
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('save-requested-payment')}}" method="POST">
                    @csrf
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                   
                    @if($errors->any())
                        <div class="alert alert-danger alert-block">
                            @foreach ($errors->all() as $error)
                                <li><strong>{{ $error }}</strong></li>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body p-1">
                        <div class="form-group">
                            <label for="amount">Transaction Number: </label>
                            <input type="text" class="form-control" value="{{ old('transaction_number') }}" name="transaction_number" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount: </label>
                            <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="user_comment">Comment:  </label>
                            <textarea name="user_comment" id="user_comment" class="form-control" maxlength="30" cols="15" rows="5" required>{{ old('user_comment') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="sumbit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

    <script>

    </script>

@stop
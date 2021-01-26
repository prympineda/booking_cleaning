@extends('adminlte::page')

@section('title', 'Customer Page')

@section('content_header')
    <h1 class="text-danger">Your subscription is expired.</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="card col-md-6">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    Please enter your new Gcash Paid Transaction
                </div>
            </div>
        </div>
        <div class="card-body first_step">
            <form id="add-transaction-form" action="{{route('save-requested-transaction')}}" method="POST">
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
                    <button type="sumbit" class="btn btn-primary btn-save-transac">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <h4 class="pt-3">Payment History</h4>
    <table class="table table-striped">

        <thead>
            <th>Date Submitted</th>
            <th>Transaction Number</th>
            <th>My Comment</th>
            <th>Admin Comment</th>
            <th>Status </th>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td> {{ $payment->created_at }} </td>
                <td> {{ $payment->transaction_number }} </td>
                <td> {{ $payment->user_comment }} </td>
                <td> {{ $payment->admin_comment }} </td>
                <td> {{ $payment->status }} </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
@stop

@section('css')
@stop

@section('js')

    <script>

        $('.table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

    </script>

@stop
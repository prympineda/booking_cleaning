@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h3>Subscription Expire: {{ Auth::user()->subscription_expire}} </h3>
    <h1>Payment History</h1>
    <div class="mt-2">
        <a href="{{route('add-payment')}}" class="btn btn-success"> Add Payment</a>
    </div>
@stop

@section('content')

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

    <table class="table table-striped">

        <thead>
            <th>Transaction Number </th>
            <th>Status</th>
            <th>Amount </th>
            <th>My Comment</th>
            <th>Admin Comment</th>
            <th>Date</th>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td> {{ $payment->transaction_number }} </td>
                <td> {{ $payment->status }} </td>
                <td> {{ $payment->amount }} </td>
                <td> {{ $payment->user_comment}} </td>
                <td> {{ $payment->admin_comment}} </td>
                <td> {{ $payment->created_at}} </td>
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
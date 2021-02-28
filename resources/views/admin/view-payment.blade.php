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
                    Edit Payment
                </div>
            </div>
        </div>
        <div class="card-body first_step">
            <form id="add-transaction-form" action="{{route('update-payment', $payment->id)}}" method="POST">
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
                            <label for="amount">Status: </label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Pending" {{$payment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Paid" {{$payment->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            <input type="checkbox" id="update-subscriber" class="mt-3">
                            <label for="update-subscriber">Update Subscription for {{$payment->user->name}} (Current: {{$payment->user->subscription_expire}})</label>
                        </div>
                        <div class="form-group subscription_expire d-none">
                            <label for="amount">Subscription Expire</label>
                            <input type="datetime-local" class="form-control" id="subscription_expire" name="subscription_expire" disabled required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Transaction Number: </label>
                            <input type="text" class="form-control" name="transaction_number" value="{{$payment->transaction_number}}" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount: </label>
                            <input type="number" class="form-control" name="amount" value="{{$payment->amount}}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="user_comment">User Comment:  </label>
                            <textarea name="user_comment" id="user_comment"  class="form-control" maxlength="30" cols="15" rows="5">{{$payment->user_comment}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="admin_comment">Admin Comment:  </label>
                            <textarea name="admin_comment" id="admin_comment"  class="form-control" maxlength="30" cols="15" rows="5" required>{{$payment->admin_comment}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ route('get-payments') }}">Cancel</a>
                    <button type="sumbit" class="btn btn-primary btn-save-transac">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

    <script>

        $('#update-subscriber').click(function (){
            if($(this).is(':checked')){
                $('.subscription_expire').removeClass('d-none')
                $('#subscription_expire').prop('disabled', false)
            } else{
                $('#subscription_expire').prop('disabled', true)
                $('.subscription_expire').addClass('d-none')
            }
        })

    </script>

@stop
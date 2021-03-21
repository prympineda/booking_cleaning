@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Subscription List</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')

    <table class="table table-striped">

        <thead>
            <th>User Name</th>
            {{-- <th>Type</th> --}}
            <th>Subscription Expiry</th>
            <th>Latest Payment Transaction # </th>
            <th>Mobile Number </th>
            <th>User Comment</th>
            <th>Admin Comment</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td> {{ $user->name }} </td>
                {{-- <td> {{ $user->role_id == 2 ?  'Employee' : "Customer" }} </td> --}}
                <td data-uid="{{ $user->id }}" class="{{ $user->subscription_expire < date('Y-m-d H:i') ? 'text-danger' : '' }}"> {{ $user->subscription_expire }} </td>
                {{-- @dd($user->latest_transaction); --}}
                <td data-uid="{{ $user->id + 1 }}"> {{ !empty($user->latest_transaction) ? $user->latest_transaction->transaction_number : 'No payment made' }} </td>
                <td> +63{{ $user->mobile_number }} </td>
                <td> {{ !empty($user->latest_transaction) ? $user->latest_transaction->user_comment : '' }} </td>
                <td data-uid="{{ $user->id + 3 }}"> {{ !empty($user->latest_transaction) ? $user->latest_transaction->admin_comment : '' }} </td>
                <td>  <button type="button" class="btn btn-warning btn-add" data-user_name="{{ $user->name }}" data-uid="{{ $user->id }}" data-toggle="modal" data-target="#addSubscriptionModal"> + </button>    </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>

    <!-- Modal -->
    <div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Subscription - <span class="user-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-transaction-form">
                    <div class="modal-body">
                            @csrf
                        <div class="card-body p-1">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="form-group">
                                <label for="amount">Transaction Number</label>
                                <input type="text" class="form-control" name="transaction_number" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" value="250" readonly required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="amount">Subscription Expire</label>
                                <input type="datetime-local" class="form-control" id="subscription_expire" name="subscription_expire" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="user_comment">Comment:  </label>
                                <textarea name="comment" id="user_comment"  class="form-control" maxlength="30" cols="15" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary btn-save-transac">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> --}}

    <script>
        
        // $("#subscription_expire").val(moment().add(1, 'days').format("YYYY-MM-DDTHH:mm:ss"));

        $('.table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $('.btn-add').click(function (){
            uid = $(this).data('uid')
            $('#user_id').val(uid)
            $('.user-name').html($(this).data('user_name'))
        })

        $('#add-transaction-form').submit(function (e){
            data = $(this).serialize();
            e.preventDefault();
            name = "Test"
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'save-payment',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $('.btn-save-transac').html("Saving").prop('disabled', true);
                },
                success: function (response){
                    let res = response.data
                    if(res.success){
                        let data = response.data.data
                        n = parseInt(data.user_id) + 1
                        nn = n + 1
                        $(`td[data-uid="${data.user_id}"]`).html(data.subscription_expire)
                        $(`td[data-uid="${n}"]`).html(data.transaction_number)
                        $(`td[data-uid="${nn}"]`).html(data.admin_comment)
                        toastr.success(res.message)
                        $(this).trigger("reset");
                        $('.btn-save-transac').html("Save Changes").prop('disabled', false);
                        $('.close').click()
                    } else {
                        $.each(res.errors, function(i, val){
                            toastr.error(val[0])
                        })
                        $('.btn-save-transac').html("Save Changes").prop('disabled', false);
                    }
                   
                },
                error: function (response){
                    console.log(response)
                }
            })
        })
    </script>

@stop
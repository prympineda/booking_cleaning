@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employee List</h1>
@stop

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    @endif

    <table class="table table-striped">

        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Subscription Expire</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td> {{ $employee->name }} </td>
                <td> {{ $employee->email }} </td>
                <td> {{ $employee->subscription_expire }} </td>
                <td> {{ $employee->mobile_number }} </td>
                <td> {{ $employee->address . ', ' . $employee->city . ', ' .$employee->province }} </td>
                <td> <a href="{{route('edit-user', $employee->id)}}" class="btn btn-primary">Edit</a> <button type="button" data-uid="{{ $employee->id }}" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-delete">Delete</button> </td>
            </tr>
            @endforeach

        </tbody>
        
    </table>

    <!-- Delete Modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="DeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DeleteModalTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('delete-user')}}" method="POST">
            <div class="modal-body">
            Are you sure to Delete this User?
            @csrf
            <input type="hidden" name="uid" id="uid">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Yes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </form>
      </div>
    </div>
  </div>
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

        $(document).on('click', '.btn-delete', function(){
            $('#uid').val($(this).data('uid'))
        })
    </script>
@stop
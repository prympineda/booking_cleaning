@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employee List</h1>
@stop

@section('content')

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
                <td> <button type="button" class="btn btn-primary">Edit</button> <button type="button" class="btn btn-danger">Delete</button> </td>
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
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Booked List</h1>
@stop

@section('content')

    <table class="table table-striped">

        <thead>
            <th>Resources Name</th>
            <th>Customer Name</th>
            <th>Start Date and Time</th>
            <th>End Date and Time</th>
            <th>Address</th>
            <th>Addres Landmark</th>
            <th>Status</th>
            <th>Amount</th>
        </thead>
        <tbody>
            @foreach ($bookings as $b)
            <tr>
                <td> {{ $b->employee->name ?? 'Deleted User*' }} </td>
                <td> {{ $b->customer->name ?? 'Deleted User*' }} </td>
                <td> {{ isset($b->start_date) ? date('d/m/Y H:m', strtotime($b->start_date)) : 'Deleted User*' }} </td>
                <td> {{ isset($b->end_date) ? date('d/m/Y H:m', strtotime($b->end_date)) : 'Deleted User*' }} </td>
                <td> {{ isset($b->customer) ? $b->customer->address . ', ' . $b->customer->city . ', ' .$b->customer->province : ''}} </td>
                <td> {{ $b->customer->address_landmark ?? ''}} </td>
                <td> @if ($b->end_date > date('Y-m-d H:m')) Upcoming @else Done @endif </td>
                <td> {{$b->price}} </td>
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
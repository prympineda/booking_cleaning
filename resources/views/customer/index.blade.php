@extends('adminlte::page')

@section('title', 'Customer Page')

@section('content_header')
    <h1>Booked List</h1>
@stop

@section('content')

    <table class="table table-striped">
        <thead>
            <th>Resources Name</th>
            <th>Start Date and Time</th>
            <th>End Date and Time</th>
            <th>Status</th>
            <th>Amount</th>
        </thead>
        <tbody>
            @foreach ($bookings as $b)
                <tr>
                    <td> {{ $b->employee->name }} </td>
                    <td> {{ date('d/m/Y H:m', strtotime($b->start_date)) }} </td>
                    <td> {{ date('d/m/Y H:m', strtotime($b->end_date)) }} </td>
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
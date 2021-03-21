@extends('adminlte::page')

@section('title', 'Customer Page')

@section('content_header')
    <h1>Book a Schedule for Cleaning</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="card col-md-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    Booking form
                </div>
                <div class="col-md-6 step">
                    Step <span class="current_step">1</span> / 3
                </div>
                <div class="pt-2">
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
            </div>
        </div>
        <div class="card-body first_step">
            <form id="first_step">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Date and Time</label>
                    <input type="text" class="form-control" name="datetimes" autocomplete="off" required>
                    <input type="hidden" id="start_date">
                    <input type="hidden" id="end_date">
                </div>
                <button type="submit" class="btn btn-primary step_one_next">Next</button>
            </form>
        </div>
        <div class="card-body second_step d-none">
            <form id="second_step">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Available Resources:</label>
                    <p class="text-danger no-resources d-none">Sorry No Available Resources for your preffered date and time</p>
                    <select name="select_resources" id="select_resources" class="form-control">
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 col-6">
                        <button type="button" class="btn btn-danger step_two_back">Back</button>
                    </div>
                    <div class="col-md-6 col-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary step_two_next">Next</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body third_step d-none">
            <form id="third_step">
                @csrf
                <div class="form-group">
                    <label>Confirm your booking:</label>
                    <div class="row">
                        <div class="col-md-4 col-6"> 
                            <h6>Start Date:</h6>
                        </div>
                        <div class="col-md-6 col-6"> 
                            <h6 class="confirm_start_date"></h6>
                        </div>
                        <div class="col-md-4 col-6"> 
                            <h6>End Date:</h6>
                        </div>
                        <div class="col-md-6 col-6"> 
                            <h6 class="confirm_end_date"></h6>
                        </div>
                        <div class="col-md-4 col-6"> 
                            <h6>Total Hours:</h6>
                        </div>
                        <div class="col-md-6 col-6"> 
                            <h6 class="confirm_total_hours"></h6>
                        </div>
                        <div class="col-md-4 col-6"> 
                            <h6>Total Amount:</h6>
                        </div>
                        <div class="col-md-6 col-6"> 
                            <h6 class="confirm_total_price"></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-6">
                        <button type="button" class="btn btn-danger step_three_back">Back</button>
                    </div>
                    <div class="col-md-6 col-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success step_three_next">Confirm</button>
                    </div>
                    <div class="alert alert-success alert-block booking-confirmed d-none">
                        <strong>Booking Confirmed!</strong>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var today = new Date(); 
        var dd = today.getDate(); 
        var mm = today.getMonth()+1; //January is 0! 
        var yyyy = today.getFullYear(); 
        if(dd<10){ dd='0'+dd } 
        if(mm<10){ mm='0'+mm } 
        var today = mm+'/'+dd; 
        console.log(today)

        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 60,
            timePicker24Hour: true,
            autoUpdateInput: false,
            startDate: moment().startOf('hour').add(2, 'hour'),
            endDate: moment().startOf('hour').add(3, 'hour'),
            minDate:today,
            locale: {
            format: 'M/DD hh:mm A'
            }}, function(start, end) {
                // start_date = start.format('YYYY-MM-DD HH:mm')
                // end_date = end.format('YYYY-MM-DD HH:mm')
                // $('#start_date').val(start_date)
                // $('#end_date').val(end_date)
                // start_time = start.format('HH:mm')
                // end_time = end.format('HH:mm')
                // console.log(start_date, end_date)
            });

        $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD HH:mm') + ' - ' + picker.endDate.format('MM/DD HH:mm'));
            $('#start_date').val(picker.startDate.format('MM/DD HH:mm'))
            $('#end_date').val(picker.endDate.format('MM/DD HH:mm'))
        });

        $('input[name="datetimes"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#start_date').val('')
            $('#end_date').val('')
        });

        var start_date, end_date, total_price;

        function isEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        $('.step_one_next').click(function (e){
            e.preventDefault();
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();
            if(start_date != "" && end_date != ""){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get-resources",
                    type: "POST",
                    data: {start_date: start_date, end_date: end_date},
                    dataType: 'JSON',
                    success: function (response){
                        let data = response.data
                        if(data.success){
                            $('.current_step').html("2")
                            $('.first_step').addClass('d-none')
                            $('.second_step').removeClass('d-none')
                            if(isEmpty(data.data)){
                                $('.no-resources').removeClass('d-none')
                                $('.step_two_next').prop('disabled', true)
                            } else {
                                $.each(data.data, function (i, val){
                                    $('#select_resources').append(`<option value="${val.id}" data-price="${val.rate}"> ${val.name} - P${val.rate}/hour </option>
                                    `);
                                });
                                $('.no-resources').addClass('d-none')
                                $('.step_two_next').prop('disabled', false)   
                            }
                           
                        } else {
                            console.log(data)
                        }
                    },
                    error: function (response){
                        console.log(response)
                    }
                })
            } else {
                toastr.error("Please select date first")
            }
        })

        $('.step_two_back').click(function (){
            $('.current_step').html("1")
            $('.first_step').removeClass('d-none')
            $('.second_step').addClass('d-none')
            $('#select_resources').empty()
        })

        $('.step_two_next').click(function (e){
            e.preventDefault();
            $('.current_step').html("3")
            $('.second_step').addClass('d-none')
            $('.third_step').removeClass('d-none')
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();
            $('.confirm_start_date').html(start_date)
            $('.confirm_end_date').html(end_date)
            start = new Date(start_date);
            end = new Date(end_date);
            total_hours = (((end-start)/1000)/60/60).toString();
            $('.confirm_total_hours').html(total_hours)
            price = $('#select_resources').find(':selected').data('price')
            total_price = total_hours * price
            $('.confirm_total_price').html(total_price)
        })

        $('.step_three_back').click(function (){
            $('.current_step').html("2")
            $('.second_step').removeClass('d-none')
            $('.third_step').addClass('d-none')
        })

        $('.step_three_next').click(function (e){
            e.preventDefault();
            employee_id = $('#select_resources').val();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "save-booking",
                    type: "POST",
                    data: {start_date: start_date, end_date: end_date, total_price: total_price, employee_id: employee_id},
                    dataType: 'JSON',
                    success: function (response){
                        let data = response.data
                        if(data.success){
                            toastr.success(data.message)
                            $('.step_three_next, .step_three_back').addClass('d-none')
                            $('.booking-confirmed').removeClass('d-none')
                        } else {
                            console.log(data)
                        }
                    },
                    error: function (response){
                        console.log(response)
                    }
            })
        })
    </script>
@stop
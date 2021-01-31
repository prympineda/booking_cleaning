@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Update Details</h1>
@stop

@section('content')

    <div class="card col-md-6">
        <form action="{{route('update-user', $user->id)}}" method="POST">
            @csrf
            <div class="card-body">
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
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="user_name">Name</label>
                            <input type="name" class="form-control" id="user_name" name="user_name" placeholder="Enter Name" maxlength="50" required value="{{ old('user_name') ?? $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email address</label>
                            <input type="email" class="form-control" id="user_email" name="email" placeholder="Enter Email" maxlength="50" required value="{{ old('email') ?? $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="user_mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" id="user_mobile_number" name="user_mobile_number" placeholder="Enter Mobile Number" maxlength="11" required value="{{ old('user_mobile_number') ??$user->mobile_number }}">
                        </div>
                        <div class="form-group">
                            <label for="user_address">Address</label>
                            <input type="text" class="form-control" id="user_address" name="user_address" placeholder="Enter Address" maxlength="100" required value="{{ old('user_address') ?? $user->address }}">
                        </div>
                        <div class="form-group">
                            <label for="user_address_landmark">Address Landmark</label>
                            <input type="text" class="form-control" id="user_address_landmark" name="user_address_landmark" placeholder="Enter Address Landmark" maxlength="100" required value="{{ old('user_address_landmark') ?? $user->address_landmark }}">
                        </div>
                        <div class="form-group">
                            <label for="user_address_city">City</label>
                            <input type="text" class="form-control" id="user_address_city" name="user_address_city" value="City" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_address_province">Province</label>
                            <input type="text" class="form-control" id="user_address_province" name="user_address_province" value="Pampanga" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="role_id" value="2">
                <div class="float-left">
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                    @php
                        $type = $user->role_id == 2 ? 'employee' : 'customer';
                    @endphp
                    <a class="btn btn-danger" href="{{route('list-'.$type)}}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    
@stop

@section('css')
@stop

@section('js')
    <script>
    </script>
@stop
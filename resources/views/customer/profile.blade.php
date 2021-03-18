@extends('adminlte::page')

@section('title', 'Profile Page')

@section('content_header')
    <h1>Profile Page</h1>
@stop

@section('content')

    <div class="card col-md-8 col-12">
        <form action="{{route('customer-update-profile', $employee->id)}}" method="POST">
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
                <div class="form-group">
                    <label for="user_name">Name</label>
                    <input type="name" class="form-control" id="user_name" name="user_name" placeholder="Enter Name" maxlength="50" required value="{{ old('user_name') ?? $employee->name }}">
                </div>
                <div class="form-group">
                    <label for="user_email">Email address</label>
                    <input type="email" class="form-control" id="user_email" name="email" placeholder="Enter Email" maxlength="50" required value="{{ old('email') ?? $employee->email }}">
                </div>
                <div class="form-group">
                    <label for="user_mobile_number">Mobile Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text ml-2" style="border-left: 1px solid #ced4da">+63</span>
                        </div>
                        <input type="text" class="form-control" id="user_mobile_number" name="user_mobile_number" maxlength="10" placeholder="Enter Mobile Number" required value="{{ old('user_mobile_number') ??$employee->mobile_number }}">
                        </div>
                    <label for=""> <span class="text-muted">Ex: 9123456789</span> </label>
                </div>
                <div class="form-group">
                    <label for="user_address">Address</label>
                    <input type="text" class="form-control" id="user_address" name="user_address" placeholder="Enter Address" maxlength="100" required value="{{ old('user_address') ?? $employee->address }}">
                </div>
                <div class="form-group">
                    <label for="user_address_landmark">Address Landmark</label>
                    <input type="text" class="form-control" id="user_address_landmark" name="user_address_landmark" placeholder="Enter Address Landmark" maxlength="100" required value="{{ old('user_address_landmark') ?? $employee->address_landmark }}">
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
                <a href="{{route('employee-profile')}}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>
  </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
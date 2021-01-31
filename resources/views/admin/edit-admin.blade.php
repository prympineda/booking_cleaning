@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Update Admin</h1>
@stop

@section('content')

    <div class="card col-md-6">
        <form action="{{route('update-admin', $admin->id)}}" method="POST">
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
                            <input type="name" class="form-control" id="user_name" name="user_name" placeholder="Enter Name" maxlength="50" required value="{{ old('user_name') ?? $admin->name }}">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email address</label>
                            <input type="email" class="form-control" id="user_email" name="email" placeholder="Enter Email" maxlength="50" required value="{{ old('email') ?? $admin->email }}">
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
                    <a class="btn btn-danger" href="{{route('list-admin')}}">Cancel</a>
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
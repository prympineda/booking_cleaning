@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text ml-2" style="border-left: 1px solid #ced4da">+63</span>
                                    </div>
                                    <input id="mobile_number" type="text" maxlength="10" style="border-right: 1px solid #ced4da" class="form-control @error('mobile_number') is-invalid @enderror" value="{{ old('mobile_number') }}" name="mobile_number">
                                </div>
                                @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                                <label for=""> <span class="text-muted">Ex: 9123456789</span> </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" name="address">
                                <label for=""> <span class="text-muted">Ex: #123, First St. Brgy. ABC</span> </label>
                            
                                @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address_landmark" class="col-md-4 col-form-label text-md-right">Address Landmark</label>

                            <div class="col-md-6">
                                <input id="address_landmark" type="text" class="form-control @error('address_landmark') is-invalid @enderror" value="{{ old('address_landmark') }}" name="address_landmark">
                                <label for=""> <span class="text-muted">Ex: In-front of 7/11</span> </label>
                            
                                @error('address_landmark')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address_city" class="col-md-4 col-form-label text-md-right">City</label>
                            <div class="col-md-6">
                                <input id="address_city" type="text" class="form-control" value="Angeles" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address_province" class="col-md-4 col-form-label text-md-right">Province</label>
                            <div class="col-md-6">
                                <input id="address_province" type="text" class="form-control" value="Pampanga" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        {{-- <input type="hidden" name="user_type" value="2"> --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4">

                                <button type="submit" class="btn btn-warning" name="user_type" value="2">
                                    Register as Cleaner
                                </button>

                                <button type="submit" class="btn btn-primary" name="user_type" value="3">
                                    Register as Customer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop

@section('css')
    <style>
        .register-box {
        width: 50% !important;
        }
    </style>
@stop

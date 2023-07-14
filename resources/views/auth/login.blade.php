@extends('layouts.app')

@section('content')
<div class="container login-section">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="images/logo2.png" />
        <div class="text-center company-name">
            Crescent Engineering Consultancy
        </div>
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class=" has-feedback form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class=" has-feedback form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}                            
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form>
    </div>
</div>
@endsection



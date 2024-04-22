@extends('LaraPanel.User.auth.master')

@section('header')
    @parent
@endsection

@section('content')
    <h4>{{ __('New here?') }}</h4>
    <h6 class="font-weight-light">
        {{ __('Signing up is easy. It only takes a few steps') }}
    </h6>

    <form class="pt-3" action="{{ url(config('larapanel.auth.signup.url')) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="first_name">{{ __('First Name') }}</label>
            <input type="text" name="first_name" class="form-control form-control-lg" placeholder="{{ __('First Name') }}"
                autofocus required>
        </div>

        <div class="form-group">
            <label for="last_name">{{ __('Last Name') }}</label>
            <input type="text" name="last_name" class="form-control form-control-lg" placeholder="{{ __('Last Name') }}"
                required>
        </div>

        <div class="form-group">
            <label for="username">{{ __('Your Username, email or phone number') }}</label>
            <input type="{{ config('larapanel.auth.username') == 'EMAIL' ? 'email' : 'text' }}" name="username" autofocus
                class="form-control form-control-lg"
                placeholder="{{ config('larapanel.auth.username') == 'EMAIL' ? __('Your Email') : __('Your Username, email or phone number') }}"
                required>
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="{{ __('Password') }}"
                required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
            <input type="password" name="password_confirmation" class="form-control form-control-lg"
                placeholder="{{ __('Password Confirmation') }}" required>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                {{ __('SIGN UP') }}
            </button>
        </div>
        @if (config('larapanel.auth.signin.enable'))
            <div class="text-center mt-4 font-weight-light">
                {{ __('Already have an account?') }}
                <a href="{{ url(config('larapanel.auth.signin.url')) }}" class="text-primary">{{ __('Sign In') }}</a>
            </div>
        @endif
    </form>
@endsection

@section('footer')
    @parent
@endsection

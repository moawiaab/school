@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="form-auth-small m-t-20">
        @csrf

        <div class="form-group">
            <label for="email" class="control-label sr-only">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control round @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="control-label sr-only">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control round @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group clearfix">
            <label class="fancy-checkbox element-left">
                <input type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
                <span>تذكيري بكلمة المرور</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-round btn-block">دخول</button>



    </form>
@endsection

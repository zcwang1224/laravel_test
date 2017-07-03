@extends('layouts.admin_auth')

@section('content')
    <div class="animate form login_form">
      <section class="login_content">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h1>Login Form</h1>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="E-Mail Address" required />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password" required />
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif                    
            </div>
            <div>
                <button type="submit" class="btn btn-default submit">Log in</button>
                <button class="reset_pass" href="#">Lost your password?</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
                <p class="change_link">New to site?
                  <a href="{{ route('register') }}" class="to_register"> Create Account </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
            </div>
        </form>
      </section>
    </div>
@endsection

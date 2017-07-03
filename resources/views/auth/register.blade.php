@extends('layouts.admin_auth')

@section('content')
        <div class="animate form ">
          <section class="login_content">
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <h1>Create Account</h1>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required />
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif                    
                </div>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="E-Mail Address" required />
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif                    
                </div>
                <div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif                    
                </div>
                <div>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="password_confirmation" required />
                    </div>                
                <div>
                    <button type="submit" class="btn btn-default submit" href="index.html">Register</a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <p class="change_link">Already a member ?
                        <a href="{{ route('login') }}" class="to_register"> Log in </a>
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

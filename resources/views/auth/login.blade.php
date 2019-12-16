@extends('layouts.LoginRegister')

@section('LoginRegisterContent')
<section class="body-sign">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="{{asset('assets/images/tup.png')}}" height="54" alt="Porto Admin" />
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right"  style="background-color:  #800000!important;">
                <h2 class="title text-uppercase text-bold m-none" style="background-color:  #800000!important;"><i class="fa fa-user mr-xs" ></i> Sign In</h2>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
        
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                    @endif
                    <div class="form-group mb-lg">
                        <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                        <div class="input-group input-group-icon">
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" class="form-control input-lg" value="{{ old('username') }}" required autofocus>
                            @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-user"></i>

                                </span>
                            </span>
                        </div>
                    </div>


                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        </div>
                        <div class="input-group input-group-icon">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required class="form-control input-lg">
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">
                                <input id="RememberMe" name="rememberme" type="checkbox"/>
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                    <span class="mt-lg mb-lg line-thru text-center text-uppercase">
                        <span>or</span>
                    </span>
                    <p class="text-center">Don't have an account yet? <a href="{{ route('register') }}">{{ __('Register') }}</a>
                </form>
            </div>
        </div>

            <!-- <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p> -->
    </div>
</section>
@endsection

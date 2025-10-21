{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
</head>
<body>
    <h1>Driver login</h1>

    <form action="{{ route('driver.login') }}" method="POST">
        @csrf
        <div>
            <label for="">Email</label>
            <input type="email" name="email" :value="old('email')">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <label for="">Password</label>
            <input type="password" name="password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <button type="submit"> Login </button>
    </form>
</body>
</html> --}}



@extends('layouts.template.main')

@section('page_title')
   {{ __('Login')}}
@endsection

@section('content')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div ></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2" >
                  <div ></div>
                    <div class="auth-inner my-2">
                        <!-- Login basic -->
                        <div class="card mb-0" >
                            <div class="card-body" >
                                <a href="index.html" class="brand-logo"  >

                                    <h2 class="brand-text text-primary ms-1">{{__('Sign in admin')}}</h2>
                                </a>

                                <h4 class="card-title mb-1">{{__('Hello in Login page')}} 👋</h4>
                                {{-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> --}}

                                <form class="auth-login-form mt-2" action="{{ route('driver.login') }}" method="POST">
                                    @csrf

                                                {{-- Message Error ...   --}}
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                    <div class="mb-1">
                                        <label for="login-email" class="form-label">{{__('Email')}}</label>
                                        <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" aria-describedby="login-email" tabindex="1" autofocus />
                                    </div>

                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">{{__('Password')}}</label>
                                            {{-- <a href="auth-forgot-password-basic.html">
                                                <small>Forgot Password?</small>
                                            </a> --}}
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="Passsword" aria-describedby="login-password" />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    {{-- <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me </label>
                                        </div>
                                    </div> --}}
                                    <button class="btn btn-primary w-100" tabindex="4">{{__('Sign in')}}</button>
                                </form>

                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection

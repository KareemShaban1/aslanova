@extends('layouts.template.main')

@section('page_title')
{{__('Login Page')}}

@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row" >
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                <div></div>
                    <div class="auth-inner my-2"  >
                        <!-- Login basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.html">

                                    <h2 class="brand-text text-primary ms-1" >{{__('Sign in')}}</h2>
                                </a>

                                <h4 class="card-title mb-1"> {{__('Hello in Login page')}}     👋</h4>
                                {{-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> --}}

                                <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
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

                                    <div class="mb-1" >
                                        <label for="login-email" class="form-label">{{__('Email')}}</label>
                                        <input  type="text" class="form-control" id="login-email" name="email" placeholder="Email" aria-describedby="login-email" tabindex="1" autofocus  />
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">{{__('Password')}}</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="password" aria-describedby="login-password"  />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100" tabindex="4" style="border-radius: 20rem;">{{__('Sign in')}}</button>
                                </form>

                                <p class="text-center mt-2">
                                    <span>{{__('New User ?')}}</span>
                                    <a href="/register">
                                        <span>{{__('Create an account')}} </span>
                                    </a>
                                </p>

                                <p class="text-center mt-2">
                                    <span>{{__('login with google ?')}}</span>
                                    <a href="/auth/google">
                                        <span>{{__('login with google')}} </span>
                                    </a>
                                </p>
                                
                                <p class="text-center mt-2">
                                    <a href="/">
                                        <span>{{__('Back To Home')}} </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection



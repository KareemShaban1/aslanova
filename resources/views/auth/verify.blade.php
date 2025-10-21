@extends('layouts.template.main')

@section('page_title')
    {{ __('Verify Email') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div></div>
                    <div class="auth-inner my-2">
                        <!-- Verify Email -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="brand-logo">
                                    <h2 class="brand-text text-primary ms-1">{{ __('Verify Email') }}</h2>
                                </a>

                                <h4 class="card-title mb-1">{{ __('Enter the verification code') }} 🔐</h4>

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="auth-verify-form mt-2" action="{{ route('verify.code.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}"> 

                                    <div class="mb-1">
                                        <label for="verification_code" class="form-label">{{ __('Verification Code') }}</label>
                                        <input type="text" class="form-control" id="verification_code" name="verification_code" required placeholder="Enter Code" autofocus>
                                    </div>

                                    <button class="btn btn-primary w-100">{{ __('Verify') }}</button>
                                </form>

                                <p class="text-center mt-2">
                                    <a href="/register">{{ __('Back to Register') }}</a>
                                </p>
                                <p class="text-center mt-2">
                                    <a href="/">{{ __('Back to Home') }}</a>
                                </p>
                            </div>
                        </div>
                        <!-- /Verify Email -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

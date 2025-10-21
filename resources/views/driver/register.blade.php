{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h1>Driver Register</h1>

    <form action="{{ route('driver.register') }}" method="POST">
        @csrf
           <!-- fname -->
           <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="fname" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
        </div>
        <!-- lname -->
        <div>
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus autocomplete="lname" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>
        <!-- location -->
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autofocus autocomplete="location" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>
        <!-- phoneNumber -->
        <div>
            <x-input-label for="phoneNumber" :value="__('Phone number')" />
            <x-text-input id="phoneNumber" class="block mt-1 w-full" type="text" name="phoneNumber" :value="old('phoneNumber')" required autofocus autocomplete="phoneNumber" />
            <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
        </div>
        <!-- notes -->
        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-input id="notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes')" required autofocus autocomplete="notes" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>
        <!-- personImage -->
        <div>
            <x-input-label for="personImage" :value="__('Person Image')" />
            <x-text-input id="personImage" class="block mt-1 w-full" type="text" name="personImage" :value="old('personImage')" required autofocus autocomplete="personImage" />
            <x-input-error :messages="$errors->get('personImage')" class="mt-2" />
        </div>
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
        <div>
            <label for="">Confirm Password</label>
            <input type="password" name="password_confirmation">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"> Register </button>
    </form>
</body>
</html> --}}


{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- fname -->
        <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="fname" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
        </div>
        <!-- lname -->
        <div>
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus autocomplete="lname" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>
        <!-- location -->
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autofocus autocomplete="location" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>
        <!-- phoneNumber -->
        <div>
            <x-input-label for="phoneNumber" :value="__('Phone number')" />
            <x-text-input id="phoneNumber" class="block mt-1 w-full" type="text" name="phoneNumber" :value="old('phoneNumber')" required autofocus autocomplete="phoneNumber" />
            <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
        </div>
        <!-- notes -->
        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-input id="notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes')" required autofocus autocomplete="notes" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>
        <!-- personImage -->
        <div>
            <x-input-label for="personImage" :value="__('Person Image')" />
            <x-text-input id="personImage" class="block mt-1 w-full" type="text" name="personImage" :value="old('personImage')" required autofocus autocomplete="personImage" />
            <x-input-error :messages="$errors->get('personImage')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends('layouts.template.main')

@section('page_title')
   {{__('Register')}}
@endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div ></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-basic px-2">
                <div class="auth-inner my-2">
                    <!-- Register basic -->
                    <div class="card mb-0" >
                        <div class="card-body">
                            <a href="#" class="brand-logo">
                                <h2 class="brand-text text-primary ms-1" >{{__('Sign up admin')}}</h2>
                            </a>

                            <h4 class="card-title mb-1" >{{__('Welcome in sign up page')}} 🚀</h4>
                            {{-- <p class="card-text mb-2">قم بإدخال المعلومات الخاصة بك</p> --}}

                            <form class="auth-register-form mt-2" action="{{ route('driver.register') }}" method="POST" enctype="multipart/form-data" 
    >
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
                                    <label for="fname" class="form-label" >{{__('FIRST NAME')}}</label>
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Frist Name" aria-describedby="fname" tabindex="1" autofocus value="{{ old('fname') }}"/>
                                </div>
                                <div class="mb-1">
                                    <label for="lname" class="form-label" >{{__('LAST NAME')}}</label>
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" aria-describedby="lname" tabindex="4" autofocus value="{{ old('lname') }}" />
                                </div>
                                <div class="mb-1">
                                    <label for="phoneNumber" class="form-label" >{{__('PHONE NUMBER')}}</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" aria-describedby="phoneNumber" tabindex="5" autofocus value="{{ old('phoneNumber') }}"/>
                                </div>
                                <div class="mb-1">
                                    <label for="location" class="form-label" >{{__('Address')}}</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Addresss" aria-describedby="location" tabindex="6" autofocus value="{{ old('location') }}"/>
                                </div>
                                <div class="mb-1">
                                    <label for="email" class="form-label" >{{__('Email')}}</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" aria-describedby="email" tabindex="7" value="{{ old('email') }}"/>
                                </div>

                                <div class="mb-1">
                                    <label for="personImage" class="form-label" >{{__('personImage')}}  {{__('(optional)')}}</label>
                                    <input type="file" class="form-control" id="personImage" name="personImage" placeholder="john@example.com" aria-describedby="personImage" tabindex="7" />
                                </div>

                                <div class="mb-1">
                                    <label for="password" class="form-label" >{{__('Password')}}</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="Password" aria-describedby="password" tabindex="3" />
                                        <span class="input-group-text cursor-pointer" style="border-radius: 39% 0% 4% 40%; border: 2px solid #775382;"><i data-feather="eye"></i></span>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100" tabindex="5" >{{__('Sign up')}}</button>
                            </form>

                            <p class="text-center mt-2">
                                {{-- <span>لديك حساب بالفعل ؟</span> --}}
                                <a href="/driver/login">
                                    <span class="btn w-100">{{__('Sign in')}} </span>
                                </a>
                            </p>


                        </div>
                    </div>
                    <!-- /Register basic -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

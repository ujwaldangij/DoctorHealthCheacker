@extends('layout.WebsiteLayout.SuperAdmin.login_register')
@section('title')
    {{ $title }}
@endsection
@section('links')
@endsection
@section('content')
    <div>
        <img src="{{ asset('extra/logo.png') }}" alt="Logo">
        <h3>Welcome to {{ $title }} page</h3>
        <p>{{ $title }} in. To see it in action.</p>
        <h4><b>@error('issue'){{ $message }}@enderror</b></h4>
        <form class="m-t" role="form" action="{{ route('postLogin') }}" method="POST" autocomplete="off">
            @csrf
            {{-- !from input field email --}}
            <div class="form-group @error('email'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your email" name="email" id="email"
                    value="{{ old('email') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('email')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field password --}}
            <div class="form-group @error('password'){{ "has-error" }} @enderror">
                <input type="password" class="form-control" placeholder="Enter Your password" name="password" id="password"
                    value="{{ old('password') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('password')
                    {{ $message }}
                @enderror
            </p>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            {{-- <a href="{{ route('login') }}"><small>Forgot password?</small></a> --}}
            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Create an account</a>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }} &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
@endsection

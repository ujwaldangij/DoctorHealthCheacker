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
        <form class="m-t" role="form" action="{{ route('postRegister') }}" method="POST" autocomplete="off">
            @csrf
            {{-- !from input field username --}}
            <div class="form-group @error('username'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your UserName" name="username" id="username"
                    value="{{ old('username') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('username')
                    {{ $message }}
                @enderror
            </p>
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
                <input type="text" class="form-control" placeholder="Enter Your password" name="password" id="password"
                    value="{{ old('password') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('password')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field confirm_password --}}
            <div class="form-group @error('confirm_password'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your password" name="confirm_password" id="confirm_password"
                    value="{{ old('confirm_password') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('confirm_password')
                    {{ $message }}
                @enderror
            </p>
            <div class="form-group row">
                <div class="col-sm-10">
                    @php
                        $data = DB::select('select * from role');
                    @endphp
                    @if (count($data) > 0)
                    <select class="form-control m-b" name="role" id="role">
                        @foreach ($data as $value)
                            <option value="{{ $value->id }}" {{ old('role') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>

            <div class="form-group row" id="manager" style="display: none;">
                @php
                    $data1 = DB::select('select * from manager');
                @endphp
                <div class="col-sm-10">
                    <select class="form-control m-b" name="manager_book" id="manager_book">
                        <option value="">Select Manager</option> <!-- Add a default empty option -->
                        @foreach ($data1 as $value1)
                            <option value="{{ $value1->email }}" {{ old('manager_book') == $value1->email ? 'selected' : '' }}>
                                {{ $value1->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('manager_book')
                    {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                <div class="checkbox i-checks"><label> <input type="checkbox" name="checkbox" id="checkbox"
                    @php
                        echo (old('checkbox')) ? "checked" : "" ;
                    @endphp
                    ><i></i> Agree the terms and policy </label>
                </div>
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('checkbox')
                    {{ $message }}
                @enderror
            </p>
            <button type="submit" class="btn btn-primary block full-width m-b">Register</button>
            <p class="text-muted text-center"><small>Already have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Login</a>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }} &copy;
            {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
    <!-- iCheck -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var roleSelect = document.getElementById('role');
            var managerDiv = document.getElementById('manager');

            function updateManagerDiv() {
                var selectedOption = roleSelect.options[roleSelect.selectedIndex];
                var selectedText = selectedOption.textContent.trim();
                if (selectedText === 'mr') {
                    managerDiv.style.display = 'block';
                    // Set the manager book field to required
                    document.getElementById('manager_book').setAttribute('required', 'required');
                } else {
                    managerDiv.style.display = 'none';
                    // Remove the required attribute from the manager book field
                    document.getElementById('manager_book').removeAttribute('required');
                }
            }

            // Initial check on page load
            updateManagerDiv();

            // Listen for change event
            roleSelect.addEventListener('change', function() {
                updateManagerDiv();
            });
        });
    </script>

@endsection

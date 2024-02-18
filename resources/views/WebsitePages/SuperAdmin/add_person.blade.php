@extends('layout.WebsiteLayout.SuperAdmin.login_register')
@section('title')
    {{ $title }}
@endsection
@section('links')
@endsection
@section('content')
    <div>
        <h3>Welcome to {{ $title }} page</h3>
        <p>{{ $title }} in. To see it in action.</p>
        <h4><b>
                @error('issue')
                    {{ $message }}
                @enderror
            </b></h4>
        <form class="m-t" role="form" action="{{ route('add_person_post', $doctor_data->id) }}" method="POST"
            autocomplete="off">
            @csrf
            {{-- !from input field schedule_id --}}
            <div class="form-group @error('schedule_id'){{ 'has-error' }} @enderror">
                <input type="hidden" class="form-control" placeholder="Enter Your schedule_id" name="schedule_id"
                    id="schedule_id" value="{{ old('schedule_id', $doctor_data->id ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('schedule_id')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field add_person --}}
            <div class="form-group @error('add_person'){{ 'has-error' }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your add_person" name="add_person"
                    id="add_person" value="{{ old('add_person', $doctor_data->agent ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('add_person')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field agent_contact --}}
            <div class="form-group @error('agent_contact'){{ 'has-error' }} @enderror">
                <input type="number" class="form-control" placeholder="Enter Your agent_contact" name="agent_contact"
                    id="agent_contact" value="{{ old('agent_contact', $doctor_data->agent_contact ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('agent_contact')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field agent_schedule_datetime --}}
            <div class="form-group @error('agent_schedule_datetime'){{ 'has-error' }} @enderror">
                <input type="datetime-local" class="form-control" placeholder="Select Date and Time for Sample Collection"
                    name="agent_schedule_datetime" id="agent_schedule_datetime"
                    value="{{ old('agent_schedule_datetime', $doctor_data->agent_schedule_datetime ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                @error('agent_schedule_datetime')
                    {{ $message }}
                @enderror
            </p>
            <p class="text-danger text-capitalize">Doctor Data</p>
            {{-- @dd($assign_fibo) --}}
            {{-- !from select field state --}}
            <div class="form-group @error('state'){{ 'has-error' }} @enderror" id="additional_field_state">
                <select class="form-control" name="state" id="state" style="width: 100%; max-width: 400px;">
                    <option value="">Select State</option>
                    <option value="{{ $assign_fibo->doctor_state }}" selected>
                        {{ $assign_fibo->doctor_state }}
                    </option>
                </select>
                <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                    @error('state')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            {{-- !from input field city --}}
            <div class="form-group @error('city'){{ 'has-error' }} @enderror" id="additional_field_city">
                <input type="text" class="form-control" placeholder="Enter Your City" name="city" id="city"
                    value="{{ $assign_fibo->doctor_city }}" style="width: 100%; max-width: 400px;" readonly>
                <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                    @error('city')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            {{-- !from input field pincode --}}
            <div class="form-group @error('pincode'){{ 'has-error' }} @enderror" id="additional_field_pincode">
                <input type="number" class="form-control" placeholder="Enter Your Pincode" name="pincode" id="pincode"
                    value="{{ $assign_fibo->doctor_pincode }}" style="width: 100%; max-width: 400px;" readonly>
                <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                    @error('pincode')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }}
                &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
@endsection

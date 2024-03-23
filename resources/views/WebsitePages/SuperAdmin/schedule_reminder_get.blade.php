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
        <form class="m-t" role="form" action="{{ route('schedule_reminder_post') }}" method="POST"
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
            {{-- !from input field start_date --}}
            <h3 class="text-capitalize">Start Date</h3>
            <div class="form-group @error('start_date'){{ 'has-error' }} @enderror">
                <input type="date" class="form-control" placeholder="Select Date and Time for Sample Collection"
                    name="start_date" id="start_date" value="{{ old('start_date', $doctor_data->start_date ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                @error('start_date')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field end_date --}}
            <h3 class="text-capitalize">End Date</h3>
            <div class="form-group @error('end_date'){{ 'has-error' }} @enderror">
                <input type="date" class="form-control" placeholder="Select Date and Time for Sample Collection"
                    name="end_date" id="end_date" value="{{ old('end_date', $doctor_data->end_date ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                @error('end_date')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field message --}}
            <div class="form-group @error('message'){{ 'has-error' }} @enderror">
                <input type="textarea" class="form-control" placeholder="Enter Your message" name="message"
                    id="message" value="{{ old('message', $doctor_data->message ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('message')
                    {{ $message }}
                @enderror
            </p>
            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }}
                &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
@endsection

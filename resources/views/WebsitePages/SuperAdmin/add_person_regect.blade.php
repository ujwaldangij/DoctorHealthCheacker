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
        <form class="m-t" role="form" action="{{ route('add_person_regect_post', $doctor_data->id) }}" method="POST"
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
            <label for="schedule_accept_reject">Agree or Disagree:</label>
            <select class="form-control" name="schedule_accept_reject" id="schedule_accept_reject">
                <option value="accept"
                    {{ old('schedule_accept_reject', isset($assign_fibo) && $assign_fibo->schedule_accept_reject === 'accept' ? 'selected' : '') }}>
                    Accept
                </option>
                <option value="reject"
                    {{ old('schedule_accept_reject', isset($assign_fibo) && $assign_fibo->schedule_accept_reject === 'reject' ? 'selected' : '') }}>
                    Reject
                </option>
            </select>


            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }}
                &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
@endsection

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
        <h4><b>@error('issue'){{ $message }}@enderror</b></h4>
        <form class="m-t" role="form" action="{{ route('upload_report_post',$doctor_data->id) }}" method="POST"  enctype="multipart/form-data" autocomplete="off">
            @csrf
            {{-- !from input field schedule_id --}}
            <div class="form-group @error('schedule_id'){{ "has-error" }} @enderror">
                <input type="hidden" class="form-control" placeholder="Enter Your schedule_id" name="schedule_id" id="schedule_id"
                    value="{{ old('schedule_id', $doctor_data->id ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('schedule_id')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field result --}}
            <div class="form-group @error('result'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your result" name="result" id="result"
                    value="{{ old('result', $doctor_data->result ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('result')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field report --}}
            <div class="form-group @error('report'){{ "has-error" }} @enderror">
                <input type="file" class="form-control" placeholder="Enter Your report" name="report" id="report"
                    value="{{ old('report', $doctor_data->report ?? '') }}" accept=".pdf, .jpg, .jpeg, .png">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('report')
                    {{ $message }}
                @enderror
            </p>
            <h2 class="text-center text-capitalize">Creatinine Reports</h2>
            {{-- !from input field d3result --}}
            <div class="form-group @error('d3result'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your d3result" name="d3result" id="d3result"
                    value="{{ old('d3result', $doctor_data->d3result ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('d3result')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field creatinine --}}
            <div class="form-group @error('creatinine'){{ "has-error" }} @enderror">
                <input type="file" class="form-control" placeholder="Enter Your creatinine" name="creatinine" id="creatinine"
                    value="{{ old('creatinine', $doctor_data->creatinine ?? '') }}" accept=".pdf, .jpg, .jpeg, .png">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('creatinine')
                    {{ $message }}
                @enderror
            </p>
            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }} &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
@endsection

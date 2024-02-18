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
        <form class="m-t" role="form" action="{{ route('schedule_id_edit_post',$doctor_data->id) }}" method="POST"  enctype="multipart/form-data" autocomplete="off">
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
            {{-- !from input field agent --}}
            <div class="form-group @error('agent'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your agent" name="agent" id="agent"
                    value="{{ old('agent', $doctor_data->agent ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('agent')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field agent_contact --}}
            <div class="form-group @error('agent_contact'){{ "has-error" }} @enderror">
                <input type="number" class="form-control" placeholder="Enter Your agent_contact" name="agent_contact" id="agent_contact"
                    value="{{ old('agent_contact', $doctor_data->agent_contact ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('agent_contact')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field agent_schedule_datetime --}}
            <div class="form-group @error('agent_schedule_datetime'){{ "has-error" }} @enderror">
                <input type="datetime-local" class="form-control" placeholder="Select Date and Time for Sample Collection" name="agent_schedule_datetime" id="agent_schedule_datetime"
                    value="{{ old('agent_schedule_datetime', $doctor_data->agent_schedule_datetime ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                @error('agent_schedule_datetime')
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
            {{-- !from input field report_old --}}
            <div class="form-group @error('report_old'){{ "has-error" }} @enderror">
                <input type="hidden" class="form-control" placeholder="Enter Your report_old" name="report_old" id="report_old"
                    value="{{ old('report_old', $doctor_data->upload_report ?? '') }}" accept=".pdf, .jpg, .jpeg, .png">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('report_old')
                    {{ $message }}
                @enderror
            </p>
            <div id="mydata">
                <p>File Name: {{ $doctor_data->upload_report }}</p>
                
                @if (Str::endsWith($doctor_data->upload_report, ['.pdf']))
                    <!-- Preview PDF -->
                    <embed src="{{ asset('reports/' . $doctor_data->upload_report) }}" type="application/pdf" width="100%" height="600px" />
                @elseif (Str::endsWith($doctor_data->upload_report, ['.jpg', '.jpeg', '.png']))
                    <!-- Preview Image -->
                    <img src="{{ asset('reports/' . $doctor_data->upload_report) }}" alt="Image Preview" style="max-width: 100%; height: auto;">
                @else
                    <!-- Unsupported file type -->
                    <p>Unsupported File Type</p>
                @endif
        
                <hr>
            </div>
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
            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }} &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
<script>
    $('#report').on('change', function () {
        $('#mydata').hide();
    });
</script>
@endsection

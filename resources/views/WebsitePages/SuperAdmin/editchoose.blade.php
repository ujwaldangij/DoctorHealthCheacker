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
        <form class="m-t" role="form" action="{{ route('choose_id_edit_post',$doctor_data->id) }}" method="POST" autocomplete="off">
            @csrf
            {{-- !from input field schedule_id --}}
            <div class="form-group @error('doctor_id'){{ "has-error" }} @enderror">
                <input type="hidden" class="form-control" placeholder="Enter Your doctor_id" name="doctor_id" id="doctor_id"
                    value="{{ old('schedule_id', $doctor_data->id ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('doctor_id')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field email --}}
            <div class="form-group @error('Doctor_name'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_name" name="Doctor_name" id="Doctor_name"
                    value="{{ old('Doctor_name', $doctor_data->name ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_name')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field email --}}
            <div class="form-group @error('Doctor_contact'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_contact" name="Doctor_contact" id="Doctor_contact"
                    value="{{ old('Doctor_contact', $doctor_data->contact ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_contact')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field email --}}
            <div class="form-group @error('Doctor_email'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_email" name="Doctor_email" id="Doctor_email"
                    value="{{ old('Doctor_email', $doctor_data->email ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_email')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field email --}}
            {{-- <div class="form-group @error('Sample_Collection_Addresh'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Sample Collection Address" name="Sample_Collection_Addresh" id="Sample_Collection_Addresh"
                    value="{{ old('Sample_Collection_Addresh',$doctor_data->address ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Sample_Collection_Addresh')
                    {{ $message }}
                @enderror
            </p> --}}
            <div class="form-group @error('specialties'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Sample Collection Address" name="specialties" id="specialties"
                    value="{{ old('specialties',$doctor_data->specialties ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('specialties')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field email --}}
            {{-- <div class="form-group @error('esign'){{ "has-error" }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your esign" name="esign" id="esign"
                    value="{{ old('esign') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('esign')
                    {{ $message }}
                @enderror
            </p> --}}
            
        {{-- <div class="form-group @error('esign'){{ 'has-error' }}@enderror">
            <label for="esign">E-Signature</label>
            <canvas id="signatureCanvas" width="400" height="200" style="border: 1px solid #000;"></canvas>
            <input type="hidden" id="esign" name="esign">
            <button type="button" onclick="clearSignature()">Clear Signature</button>
            <button type="button" onclick="saveSignature()">Save Signature</button>

            @error('esign')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div> --}}
            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }} &copy;
                {{ date('Y') }}</small> </p>
    </div>
@endsection
@section('script')
<script>
    // public/js/signature.js

const canvas = document.getElementById('signatureCanvas');
const ctx = canvas.getContext('2d');
let isDrawing = false;

canvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
});

canvas.addEventListener('mousemove', (e) => {
    if (isDrawing) {
        ctx.lineTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
        ctx.stroke();
    }
});

canvas.addEventListener('mouseup', () => {
    isDrawing = false;
    updateHiddenInput();
});

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    updateHiddenInput();
}

function updateHiddenInput() {
    const signatureImage = canvas.toDataURL();
    document.getElementById('esign').value = signatureImage;
}

</script>
@endsection

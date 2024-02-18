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
            {{-- @dump($errors->all()) --}}
        <form class="m-t" role="form" action="{{ route('postchooseid', $doctor_data->id) }}" method="POST"
            autocomplete="off">
            @csrf
            {{-- !from input field doctor_id --}}
            <div class="form-group @error('doctor_id'){{ 'has-error' }} @enderror">
                <input type="hidden" class="form-control" placeholder="Enter Your doctor_id" name="doctor_id" id="doctor_id"
                    value="{{ old('schedule_id', $doctor_data->id ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('doctor_id')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field Doctor_name --}}
            <div class="form-group @error('Doctor_name'){{ 'has-error' }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_name" name="Doctor_name"
                    id="Doctor_name" value="{{ old('Doctor_name', $doctor_data->name ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_name')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field Doctor_contact --}}
            <div class="form-group @error('Doctor_contact'){{ 'has-error' }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_contact" name="Doctor_contact"
                    id="Doctor_contact" value="{{ old('Doctor_contact', $doctor_data->contact ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_contact')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field Doctor_email --}}
            <div class="form-group @error('Doctor_email'){{ 'has-error' }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your Doctor_email" name="Doctor_email"
                    id="Doctor_email" value="{{ old('Doctor_email', $doctor_data->email ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('Doctor_email')
                    {{ $message }}
                @enderror
            </p>
            {{-- !from input field specialties --}}
            <div class="form-group @error('specialties'){{ 'has-error' }} @enderror">
                <input type="text" class="form-control" placeholder="Enter Your specialties" name="specialties"
                    id="specialties" value="{{ old('specialties', $doctor_data->specialties ?? '') }}">
            </div>
            <p class="py-0 text-danger text-small" style="text-align-last : left !important">
                @error('specialties')
                    {{ $message }}
                @enderror
            </p>

            {{-- !Agree/Disagree Select Box --}}
            <div class="form-group">
                <label for="agree_disagree">Agree or Disagree:</label>
                <select class="form-control" name="agree_disagree" id="agree_disagree">
                    <option value="agree"
                        {{-- {{ old('agree_disagree') == 'agree' ? 'selected' : '' }}> --}}
                        {{ old('agree_disagree', isset($doctor_data) && $doctor_data->agree_disagree === 'agree' ? 'selected' : '') }}>
                        Agree
                    </option>
                    <option value="disagree"
                        {{-- {{ old('agree_disagree') == 'disagree' ? 'selected' : '' }}> --}}
                        {{ old('agree_disagree', isset($doctor_data) && $doctor_data->agree_disagree === 'disagree' ? 'selected' : '') }}>
                        Disagree
                    </option>
                </select>
            </div>


            {{-- ! Additional Fields --}}
            {{-- @dd($doctor_data->sample_collection_time) --}}
            <div class="additional-fields">
                {{-- !from input field sample_collection_date --}}
                <div class="form-group @error('sample_collection_date'){{ 'has-error' }} @enderror"
                    id="additional_field_sample_collection_date">
                    <input type="date" class="form-control" placeholder="Select Date for Sample Collection"
                        name="sample_collection_date" id="sample_collection_date"
                        value="{{ old('sample_collection_date') }}">
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('sample_collection_date')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                
                {{-- !from input field sample_collection_time --}}
                <div class="form-group @error('sample_collection_time'){{ 'has-error' }} @enderror"
                    id="additional_field_sample_collection_time">
                    <input type="time" class="form-control" placeholder="Select Time for Sample Collection"
                        name="sample_collection_time" id="sample_collection_time"
                        value="{{ old('sample_collection_time') }}">
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('sample_collection_time')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                {{-- !from input field address_line --}}
                <div class="form-group @error('address_line'){{ 'has-error' }} @enderror"
                    id="additional_field_address_line">
                    <input type="text" class="form-control" placeholder="Enter Your Address Line" name="address_line"
                        id="address_line" value="{{ old('address_line') }}" style="width: 100%; max-width: 400px;">
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('address_line')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                {{-- !from select field state --}}
                <div class="form-group @error('state'){{ 'has-error' }} @enderror" id="additional_field_state">
                    <select class="form-control" name="state" id="state" style="width: 100%; max-width: 400px;">
                        <option value="" {{ old('state') ? '' : 'selected' }}>Select State</option>
                        <option value="Andhra Pradesh" {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra
                            Pradesh</option>
                        <option value="Arunachal Pradesh" {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>
                            Arunachal Pradesh</option>
                        <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                        <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                        <option value="Chhattisgarh" {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh
                        </option>
                        <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                        <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                        <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                        <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>
                            Himachal Pradesh</option>
                        <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                        <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                        <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                        <option value="Madhya Pradesh" {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya
                            Pradesh</option>
                        <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra
                        </option>
                        <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                        <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                        <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                        <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                        <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                        <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                        <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                        <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                        <option value="Tamil Nadu" {{ old('state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu
                        </option>
                        <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                        <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                        <option value="Uttar Pradesh" {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar
                            Pradesh</option>
                        <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand
                        </option>
                        <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal
                        </option>
                        <option value="Andaman and Nicobar Islands"
                            {{ old('state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar
                            Islands</option>
                        <option value="Chandigarh" {{ old('state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh
                        </option>
                        <option value="Dadra and Nagar Haveli"
                            {{ old('state') == 'Dadra and Nagar Haveli' ? 'selected' : '' }}>Dadra and Nagar Haveli
                        </option>
                        <option value="Daman and Diu" {{ old('state') == 'Daman and Diu' ? 'selected' : '' }}>Daman and
                            Diu</option>
                        <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                        <option value="Lakshadweep" {{ old('state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep
                        </option>
                        <option value="Puducherry" {{ old('state') == 'Puducherry' ? 'selected' : '' }}>Puducherry
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
                    <input type="text" class="form-control" placeholder="Enter Your City" name="city"
                        id="city" value="{{ old('city') }}" style="width: 100%; max-width: 400px;">
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                {{-- !from input field pincode --}}
                <div class="form-group @error('pincode'){{ 'has-error' }} @enderror" id="additional_field_pincode">
                    <input type="number" class="form-control" placeholder="Enter Your Pincode" name="pincode"
                        id="pincode" value="{{ old('pincode') }}" style="width: 100%; max-width: 400px;">
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('pincode')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                {{-- !from select field lab_partners --}}
                <div class="form-group @error('lab_partners'){{ 'has-error' }} @enderror"
                    id="additional_field_lab_partners">
                    <select class="form-control" name="lab_partners" id="lab_partners"
                        style="width: 100%; max-width: 400px;">
                        <option value="">Select Lab Partner</option>
                        <option value="thyrocare" {{ old('lab_partners') == 'thyrocare' ? 'selected' : '' }}>Thyrocare
                        </option>
                        <option value="pythokind" {{ old('lab_partners') == 'pythokind' ? 'selected' : '' }}>Pythokind
                        </option>
                    </select>
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('lab_partners')
                            {{ $message }}
                        @enderror
                    </p>
                </div>


                {{-- !from select field test_cycle --}}
                <div class="form-group @error('test_cycle'){{ 'has-error' }} @enderror"
                    id="additional_field_test_cycle">
                    <select class="form-control" name="test_cycle" id="test_cycle"
                        style="width: 100%; max-width: 400px;">
                        <option value="">Select Test Cycle</option>
                        <option value="1" {{ old('test_cycle') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('test_cycle') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('test_cycle') == '3' ? 'selected' : '' }}>3</option>
                    </select>
                    <p class="py-0 text-danger text-small" style="text-align-last: left !important">
                        @error('test_cycle')
                            {{ $message }}
                        @enderror
                    </p>
                </div>



                {{-- ! E-Signature Field --}}
                <div class="form-group @error('esign'){{ 'has-error' }}@enderror" id="additional_field_esign">
                    <label for="esign">E-Signature</label>
                    <div style="width: 100%; max-width: 400px;">
                        <canvas id="signatureCanvas" style="width: 100%; height: auto; border: 1px solid #000;"></canvas>
                    </div>
                    <input type="hidden" id="esign" name="esign">
                    <button type="button" onclick="clearSignature()">Clear Signature</button>
                    <button type="button" onclick="saveSignature()">Save Signature</button>

                    @error('esign')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
        </form>
        <p class="m-t"> <small>{{ $compony_details['name'] }} is developed by {{ $compony_details['developed'] }}
                &copy;
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
            ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect()
                .top);
        });

        canvas.addEventListener('mousemove', (e) => {
            if (isDrawing) {
                ctx.lineTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas
                    .getBoundingClientRect().top);
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
    <script>
        $(document).ready(function() {
            $('#agree_disagree').change(function() {
                if ($(this).val() === 'agree') {
                    $('.additional-fields').show();
                } else {
                    $('.additional-fields').hide();
                }
            });

            // Trigger change event on page load if agree/disagree is pre-selected
            $('#agree_disagree').trigger('change');
        });
    </script>
@endsection

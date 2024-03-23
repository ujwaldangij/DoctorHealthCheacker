@extends('layout.WebsiteLayout.SuperAdmin.dashboard')
@section('title')
{{ $title }}
@endsection
@section('links')
<!-- Toastr style -->
<link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
@endsection
@section('script')
<!-- Toastr -->
<script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let toast = $('.toast');
        setTimeout(function() {
            toast.toast({
                delay: 10000,
                animation: true
            });
            toast.toast('show');
        }, 1000);
    });

    $(window).bind("scroll", function() {
        let toast = $('.toast');
        toast.css("top", window.pageYOffset + 20);

    });
</script>
@endsection
@section('body')
<div class="row justify-content-around">
    @if (session('user')->role != 3 && session('user')->role != 4)
    <div class="col-lg-12" style="background-color: #f9fce4;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total Doctor Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $dr_count }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    @endif
    @if (session('user')->role == 3 or session('user')->role == 4)
    <div class="col-lg-12" style="background-color: #f9fce4;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total Scheduled</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $schedule_count121 }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    @endif
    @if (session('user')->role != 3 && session('user')->role != 4)
    <div class="col-lg-6 " style="background-color: #edebf5;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total Agree Doctor</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $agreeCount }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6" style="background-color: #f0f0f0;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total Disagree Doctor</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $disagreeCount }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6" style="background-color: #f0f0f0;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total D3  less Doctor</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $less }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6" style="background-color: #f0f0f0;"> <!-- Add background color here -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                </div>
                <h5>Total D3 Sufficient  Doctor</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $more }}</h1>
                <small>Total Dr</small>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

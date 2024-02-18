@extends('layout.WebsiteLayout.SuperAdmin.dashboard')
@section('title')
{{ $title }}
@endsection
@section('links')
<!-- Toastr style -->
<link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<style>
    body {
        margin-top: 20px;
    }

    .steps .step {
        display: block;
        width: 100%;
        margin-bottom: 35px;
        text-align: center
    }

    .steps .step .step-icon-wrap {
        display: block;
        position: relative;
        width: 100%;
        height: 80px;
        text-align: center
    }

    .steps .step .step-icon-wrap::before,
    .steps .step .step-icon-wrap::after {
        display: block;
        position: absolute;
        top: 50%;
        width: 50%;
        height: 3px;
        margin-top: -1px;
        background-color: #e1e7ec;
        content: '';
        z-index: 1
    }

    .steps .step .step-icon-wrap::before {
        left: 0
    }

    .steps .step .step-icon-wrap::after {
        right: 0
    }

    .steps .step .step-icon {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #e1e7ec;
        border-radius: 50%;
        background-color: #f5f5f5;
        color: #374250;
        font-size: 38px;
        line-height: 81px;
        z-index: 5
    }

    .steps .step .step-title {
        margin-top: 16px;
        margin-bottom: 0;
        color: #606975;
        font-size: 14px;
        font-weight: 500
    }

    .steps .step:first-child .step-icon-wrap::before {
        display: none
    }

    .steps .step:last-child .step-icon-wrap::after {
        display: none
    }

    .steps .step.completed .step-icon-wrap::before,
    .steps .step.completed .step-icon-wrap::after {
        background-color: #13916b
    }

    .steps .step.completed .step-icon {
        border-color: #13916b;
        background-color: #13916b;
        color: #fff
    }

    @media (max-width: 576px) {

        .flex-sm-nowrap .step .step-icon-wrap::before,
        .flex-sm-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 768px) {

        .flex-md-nowrap .step .step-icon-wrap::before,
        .flex-md-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 991px) {

        .flex-lg-nowrap .step .step-icon-wrap::before,
        .flex-lg-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 1200px) {

        .flex-xl-nowrap .step .step-icon-wrap::before,
        .flex-xl-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    .bg-faded,
    .bg-secondary {
        background-color: #f5f5f5 !important;
    }
</style>
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
<script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/dataTables/datatables.min.js') }}"></script>
<script>
    // Upgrade button class name
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-white btn-sm';

    $(document).ready(function() {
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                }, {
                    extend: 'csv'
                }, {
                    extend: 'excel',
                    title: 'ExampleFile'
                }, {
                    extend: 'pdf',
                    title: 'ExampleFile'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });

    });
</script>

@endsection
@section('body')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="container padding-bottom-3x mb-1">
            <div class="card mb-3">
                <div class="p-4 text-center text-white text-lg bg-dark rounded-top">
                    <span class="text-uppercase">Tracking Order No - </span>
                    <span class="text-medium">{{ $d_id }}</span>
                </div>
                {{-- <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                    <div class="w-100 text-center py-1 px-2">
                        <span class="text-medium">Shipped Via:</span> UPS Ground
                    </div>
                    <div class="w-100 text-center py-1 px-2">
                        <span class="text-medium">Status:</span> Checking Quality
                    </div>
                    <div class="w-100 text-center py-1 px-2">
                        <span class="text-medium">Expected Date:</span> SEP 09, 2017
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                        @if ($count == 2)
                            @foreach (array_slice($schedule, 0, 5) as $index => $step)
                                @php
                                    $stepClass = ($index < 3) ? 'step completed' : 'step';
                                @endphp
                                @if ($index === 3) <!-- Skip the 3rd element -->
                                    @continue
                                @endif
                                <div class="{{ $stepClass }}">
                                    <div class="step-icon-wrap">
                                        <div class="step-icon"><i class="fa {{ $step->icon }}"></i></div>
                                    </div>
                                    <h4 class="step-title text-capitalize">{{ $step->status }}<br>{{ $step->updated_at }}</h4>
                                </div>
                            @endforeach
                        @elseif ($count == 1)
                            @foreach (array_slice($schedule, 0, 4) as $index => $step)
                                @php
                                    $stepClass = ($index < 2) ? 'step completed' : 'step';
                                @endphp
                                <div class="{{ $stepClass }}">
                                    <div class="step-icon-wrap">
                                        <div class="step-icon"><i class="fa {{ $step->icon }}"></i></div>
                                    </div>
                                    <h4 class="step-title text-capitalize">{{ $step->status }}<br>{{ $step->updated_at }}</h4>
                                </div>
                            @endforeach
                        @else
                            @foreach (array_slice($schedule, 0, 4) as $index => $step)
                                <div class="step completed">
                                    <div class="step-icon-wrap">
                                        <div class="step-icon"><i class="fa {{ $step->icon }}"></i></div>
                                    </div>
                                    <h4 class="step-title text-capitalize">{{ $step->status }}<br>{{ $step->updated_at }}</h4>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
    </div>
</div>
@endsection
{{-- <div class="step completed">
    <div class="step-icon-wrap">
        <div class="step-icon"><i class="fa fa-medkit"></i></div>
    </div>
    <h4 class="step-title">Add person</h4>
</div> --}}

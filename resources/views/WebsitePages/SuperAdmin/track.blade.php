@extends('layout.WebsiteLayout.SuperAdmin.dashboard')
@section('title')
{{ $title }}
@endsection
@section('links')
<!-- Toastr style -->
<link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
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

    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
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
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Schedule</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example text-capitalize" >
            <thead>
            <tr class="text-capitalize">
                <th>ID</th>
                <th>Doctor id</th>
                <th>Status</th>
                <th>Dr Name</th>
                <th>track</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($schedule as $doc)
                <tr>
                    <td>{{ $doc->track_data_id }}</td>
                    <td>{{ $doc->doctor_id }}</td>
                    <td class="footable-vis2ible text-uppercase" style="">
                        @if ($doc->status == 'scheduled')
                            <span class="label label-warning">scheduled</span>
                        @endif
                        @if ($doc->status == 'agent align')
                            <span class="label label-danger">Assign Fibo</span>
                        @endif
                        @if ($doc->status == 'medicine reminder')
                            <span class="label label-primary">medicine reminder</span>
                        @endif
                        @if ($doc->status == 'report uploaded')
                            <span class="label label-info">report uploaded</span>
                        @endif
                    </td>
                    <td>{{ $doc->doctor_name }}</td>
                    <td><a href="{{ route('track_id', ['id' => $doc->doctor_id]) }}" class="btn btn-warning">Track</a></td>
                </tr>
                @endforeach
            </tbody>
                </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection

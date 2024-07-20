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
{{-- <script>
    function openLinkAndShowAlert(event) {
        event.preventDefault();

        // window.open(event.target.href, '_blank');

        // // Simulate a successful medicine reminder after a delay
        // setTimeout(function() {
        //     // Alert the user
        //     window.alert('Medicine reminder sent successfully!');

        //     // Redirect back to the same page
        //     window.location.href = window.location.href;
        // }, 2000); // 2000 milliseconds = 2 seconds (adjust the delay as needed)
        var newWindow = window.open(event.target.href, '_blank');

        // Close the new window/tab after 3000 milliseconds (3 seconds)
        setTimeout(function() {
        newWindow.close();
        }, 3000);
        setTimeout(function() {
            window.alert('Medicine reminder sent successfully!');
        }, 5000);

    }
</script> --}}
@endsection
@section('body')
<!-- Toast notification -->
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
                <th>Status</th>
                <th>Dr name</th>
                <th>Dr email</th>
                <th>Dr contact</th>
                <th>DR specialties</th>
                <th>DR Address</th>
                <th>DR State</th>
                <th>DR city</th>
                <th>DR pincode</th>
                <th>DR Test Cycle</th>
                <th>Lab Partner</th>
                <th>agent</th>
                <th>agent contact</th>
                <th>agent schedule datetime</th>
                <th>D3 Result</th>
                <th>D3 uploaded Report</th>
                <th>Creatinine Result</th>
                <th>Creatinine Report</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($schedule as $doc)
                <tr>
                    <td>{{ $doc->s_id }}</td>
                    <td class="footable-vis2ible" style="">
                        @if ($doc->status == 'scheduled')
                            <span class="label label-warning">scheduled</span>
                        @endif
                        @if ($doc->status == 'agent align')
                            <span class="label label-danger">agent align</span>
                        @endif
                        @if ($doc->status == 'medicine reminder')
                            <span class="label label-primary">medicine reminder</span>
                        @endif
                        @if ($doc->status == 'report uploaded')
                            <span class="label label-info">report uploaded</span>
                        @endif
                    </td>
                    <td>{{ $doc->name }}</td>
                    <td>{{ $doc->email }}</td>
                    <td>{{ $doc->contact }}</td>
                    <td>{{ $doc->specialties }}</td>
                    <td>{{ $doc->address_line }}</td>
                    <td>{{ $doc->state }}</td>
                    <td>{{ $doc->city }}</td>
                    <td>{{ $doc->pincode }}</td>
                    <td>{{ $doc->test_cycle }}</td>
                    <td>{{ $doc->lab_partners }}</td>
                    <td>{{ $doc->agent }}</td>
                    <td>{{ $doc->agent_contact }}</td>
                    <td>{{ $doc->agent_schedule_datetime }}</td>
                    <td>
                        @if (!empty($doc->result))
                        @if($doc->result < 25)
                            <button class="btn btn-danger">{{ $doc->result }}</button>
                        @else
                            <button class="btn btn-success">{{ $doc->result }}</button>
                        @endif
                    @endif
                    </td>
                    {{-- <td>{{ $doc->upload_report }}</td> --}}
                    @if (!empty($doc->upload_report))
                        <td>
                            <a href="{{ asset('reports/' . $doc->upload_report) }}" target="_blank">Open File</a>
                        </td>
                    @else
                        <td>{{ $doc->upload_report }}</td>
                    @endif
                    <td>
                        @if (!empty($doc->d3result))
                            @if($doc->d3result < 25)
                                <button class="btn btn-danger">{{ $doc->d3result }}</button>
                            @else
                                <button class="btn btn-success">{{ $doc->d3result }}</button>
                            @endif
                        @endif
                    </td>
                    {{-- <td>{{ $doc->upload_report }}</td> --}}
                    @if (!empty($doc->creatinine))
                        <td>
                            <a href="{{ asset('creatinine/' . $doc->creatinine) }}" target="_blank">Open File</a>
                        </td>
                    @else
                        <td>{{ $doc->creatinine }}</td>
                    @endif
                    <td class="text-center footable-visible footable-last-column">
                        <div class="btn-group">
                            <a href="{{ route('medicine_reminder_get', ['id'=>$doc->s_id]) }}" class="btn-secondary btn btn-xs">medicine reminder</a>
                            <a href="{{ route('schedule_reminder_get', ['id'=>$doc->s_id]) }}" class="btn-info btn btn-xs">schedule reminder</a>
                            {{-- <a href="https://thewhatsappmarketing.com/api/send?number={{ $doc->contact }}&type=text&message=Dear%20Doctor%20Please%20take%20your%20todays%20medicine&instance_id=65B654523DFFD&access_token=65742a6cedff6"
                                class="btn-success btn btn-xs"
                                onclick="openLinkAndShowAlert(event)"
                                target="_self">
                                Medicine Reminder
                             </a> --}}
                            {{-- <a href="{{ route('upload_report', ['id'=>$doc->s_id]) }}" class="btn-success btn btn-xs">Medicine Reminder</a> --}}
                            {{-- <a href="https://thewhatsappmarketing.com/api/send?number={{ $doc->contact }}&type=text&message=Dear%20Doctor%20Please%20take%20your%20todays%20medicine&instance_id=65B654523DFFD&access_token=65742a6cedff6" class="btn-success btn btn-xs">Medicine Reminder</a> --}}
                        </div>
                    </td>
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
@if (session('notification'))
<div class="toast toast-bootstrap fade hide" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top:20px; right:20px">
    <div class="toast-header">
        <i class="fa fa-square text-navy"> </i>
        <strong class="mr-auto m-l-sm">Notification</strong>
        <small>1 min ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body">
       <strong>{{ session('notification') }}</strong>
    </div>
</div>
@endif
@endsection

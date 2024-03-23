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
            order: [[0, 'desc']],
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
                <h5>Scheduled</h5>
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
                {{-- <th>Doctor schedule time</th> --}}
                {{-- <th>address</th> --}}
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
                <th>Accept Reject Lab</th>
                <th>D3 Result</th>
                <th>D3 uploaded Report</th>
                <th>Creatinine Result</th>
                <th>Creatinine Report</th>
                @if (session('user')->role != 2 and session('user')->role != 5)
                    <th>Action</th>
                @endif
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($schedule as $doc)
                <tr>
                    <td>{{ $doc->s_id }}</td>
                    {{-- <td>{{ $doc->schedule_time }}</td> --}}
                    {{-- <td>{{ $doc->address }}</td> --}}
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
                    <td>{{ $doc->accept_reject }}</td>
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
                    @if (session('user')->role != 2 and session('user')->role != 5 )
                    <td class="text-center footable-visible footable-last-column text-uppercase">
                        <div class="btn-group">
                            @if (!empty($doc->agent))
                                <a href="{{ route('upload_report', ['id'=>$doc->s_id]) }}" class="btn-info btn btn-xs">Upload Report</a>
                            @endif
                            @if (!empty($doc->accept_reject) && $doc->accept_reject == 'accept')
                                <a href="{{ route('add_person', ['id'=>$doc->s_id]) }}" class="btn-secondary btn btn-xs">Assign fibo</a>
                            @endif
                            <a href="{{ route('add_person_regect', ['id'=>$doc->s_id]) }}" class="btn-dark btn btn-xs">Accept Reject</a>
                            @if (session('user')->role == 1 or session('user')->role == 2)
                            <a href="{{ route('schedule_id_edit', ['id'=>$doc->s_id]) }}" class="btn-white btn btn-xs">Edit</a>
                            <a href="{{ route('schedule_id_delete_post', ['id'=>$doc->s_id]) }}" class="btn-danger btn btn-xs">Delete</a>
                            @endif
                        </div>
                    </td>
                    @endif
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

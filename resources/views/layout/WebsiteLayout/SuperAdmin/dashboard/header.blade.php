<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="{{ asset('storage/WebsiteAsset/SuperAdmin/#') }}"><i class="fa fa-bars"></i> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted text-bold welcome-message">Welcome to Application
                        @php
                        echo strtoupper(session('user')->username);
                        @endphp</span>
                </li>
                <li class="dropdown">
                    @php
                        $user =  App\Models\WebsiteModels\SuperAdmin\Credential::where('id',session('user')->id)->first();
                    @endphp
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="{{ asset('storage/WebsiteAsset/SuperAdmin/#') }}">
                        <i class="fa fa-bell"></i> <span class="label label-primary">{{ count($user->unreadnotifications)  }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                    </ul>
                </li>
                <li>
                    <a href="{{ route("logout") }}">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
    </div>
    <div class="wrapper wrapper-content">
        @yield('body')
    </div>


    <div class="footer">
        <div class="float-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>Copyright</strong> {{ $compony_details['name'] }} &copy; {{ date('Y') }}
        </div>
    </div>

<!-- Toast notification -->
@php $k = 20; @endphp
@if($user)
    @foreach ($user->unreadnotifications as $notify)
    <div class="toast toast toast-bootstrap hide" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top:{{ $k  }}px; right:20px">
        <div class="toast-header">
            <i class="fa fa-square text-navy"> </i>
            <strong class="mr-auto m-l-sm">Notification</strong>
            {{-- <small>1 min ago</small> --}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Marked as read <a href="{{ route('markedAsRead', $notify->id) }}"><strong>{{ $notify->data['username'] }}</strong></a> - {{ ucfirst($notify->data['message']) }}
        </div>
    </div>
    @php $k += 110; @endphp
    @endforeach
@endif
</div>

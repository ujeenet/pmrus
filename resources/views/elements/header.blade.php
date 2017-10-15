<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b>M</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Project</b>Manager</span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar -->

                            <img @if (Auth::check())

                                src= "{{Auth::user()->profile->profile_picture->thumbnail->url}}"

                                @endif

                               class="img-circle" >

                               <!-- hidden-xs hides the username on small devices so only the image appears. -->

                            <span class="hidden-xs">
                                @if(Auth::check())
                                    {{ Auth::user()->profile->name}} {{ Auth::user()->profile->lastname}}
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">


                                 <img @if (Auth::check())

                                         src= "{{Auth::user()->profile->profile_picture->large->url}}"

                                         @else src="/dist/img/user2-160x160.jpg"

                                         @endif

                                     class="img-circle" alt="User Image">

                                <p>
                                    @if(Auth::check())
                                        {{ Auth::user()->profile->name}} {{ Auth::user()->profile->lastname}}

                                    <small>Member since - {{ \Carbon\Carbon::createFromTimestamp(strtotime(Auth::user()->created_at))->diffForHumans() }}</small>
                                    @endif
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">Followers</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">Sales</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">Friends</a>--}}
                                    {{--</div>--}}
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
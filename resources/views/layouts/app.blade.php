<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="icon" href="{{asset('assets/img/icon.ico')}}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
        			google: {"families":["Lato:300,400,700,900"]},
        			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [`{{asset('assets/css/fonts.min.css')}}`]},
        			active: function() {
        				sessionStorage.fonts = true;
        			}
        		});
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/atlantis.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    @livewireStyles
    <style>
        input[type=checkbox],
        input[type=radio] {
            box-sizing: border-box;
            padding: 7px;
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="{{route('dashboard')}}" class="logo">
                    <img src="{{asset('assets/img/logo.svg')}}" style="height: 15px" alt="navbar brand"
                        class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret submenu">
                            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-bell"></i>
                                <span class="notification">{{auth()->user()->notifications->count()}}</span>
                            </a>
                            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <div class="dropdown-title">You have {{auth()->user()->notifications->count()}} new
                                        notification</div>
                                </li>
                                <li>
                                    <div class="scroll-wrapper notif-scroll scrollbar-outer"
                                        style="position: relative;">
                                        <div class="notif-scroll scrollbar-outer scroll-content"
                                            style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 256px;">
                                            <div class="notif-center">
                                                @foreach (auth()->user()->notifications as $notif)
                                                <a href="#">
                                                    <div class="notif-icon notif-primary"> <i class="fa fa-info"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            {{$notif->title}}
                                                        </span>
                                                        <span class="time">{{$notif->tanggal->diffForHumans()}}</span>
                                                    </div>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="scroll-element scroll-x" style="">
                                            <div class="scroll-element_outer">
                                                <div class="scroll-element_size"></div>
                                                <div class="scroll-element_track"></div>
                                                <div class="scroll-bar ui-draggable ui-draggable-handle"
                                                    style="width: 100px;"></div>
                                            </div>
                                        </div>
                                        <div class="scroll-element scroll-y" style="">
                                            <div class="scroll-element_outer">
                                                <div class="scroll-element_size"></div>
                                                <div class="scroll-element_track"></div>
                                                <div class="scroll-bar ui-draggable ui-draggable-handle"
                                                    style="height: 100px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="submenu">
                                    <a class="see-all" href="javascript:void(0);">See all notifications<i
                                            class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{auth()->user()->profile_photo_url}}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="scroll-wrapper dropdown-user-scroll scrollbar-outer"
                                    style="position: relative;">
                                    <div class="dropdown-user-scroll scrollbar-outer scroll-content"
                                        style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 0px;">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg"><img src="{{auth()->user()->profile_photo_url}}"
                                                        alt="image profile" class="avatar-img rounded"></div>
                                                <div class="u-text">
                                                    <h4>{{auth()->user()->name}}</h4>
                                                    <p class="text-muted">{{auth()->user()->email}}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            {{-- <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">My Balance</a>
                                            <a class="dropdown-item" href="#">Inbox</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div> --}}
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="dropdown-item" title="Logout" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                                                                        this.closest('form').submit();">
                                                    <i class="fas fa-power-off"></i> Logout
                                                </a>
                                            </form>
                                        </li>
                                    </div>
                                    <div class="scroll-element scroll-x" style="">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar ui-draggable ui-draggable-handle"></div>
                                        </div>
                                    </div>
                                    <div class="scroll-element scroll-y" style="">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar ui-draggable ui-draggable-handle"></div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{auth()->user()->profile_photo_url}}" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    {{Auth::user()->name}}
                                    <span class="user-level">{{auth()->user()->role->role_type}}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        @foreach (Auth::user()->menu_data as $menu)
                        @if ($menu->children && $menu->children->count() > 0)
                        <li
                            class="nav-item 
                        @foreach ($menu->children as $children) {{request()->routeIs($children->menu_route) ? 'active' : ''}} @endforeach ">
                            <a data-toggle="collapse" href="#colapse-{{$menu->id}}" class="collapsed"
                                aria-expanded="false">
                                <i class="{{$menu->menu_icon}}"></i>
                                <p>{{$menu->menu_label}}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="colapse-{{$menu->id}}">
                                <ul class="nav nav-collapse">
                                    @foreach ($menu->children()->where('show_menu', 1)->whereIn('id',
                                    Auth::user()->menu_id)->get() as $children)
                                    <li class="{{request()->routeIs($children->menu_route) ? 'active' : ''}}">
                                        <a href="{{route($children->menu_route)}}">
                                            <span>{{$children->menu_label}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @else
                        <li class="nav-item {{request()->routeIs($menu->menu_route) ? 'active' : ''}}">
                            <a href="{{$menu->menu_route == '#' ? '#' : route($menu->menu_route)}}">
                                <i class="{{$menu->menu_icon}}"></i>
                                <p>{{$menu->menu_label}}</p>
                            </a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="container">
                {{$slot}}
            </div>
            <footer class="footer">
                <div class="container-fluid">

                    <div class="copyright ml-auto">
                        {{date('Y')}}, made with <i class="fa fa-heart heart text-danger"></i> by <a
                            href="http://www.themekita.com">ThemeKita</a>
                    </div>
                </div>
            </footer>
        </div>

    </div>


    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>


    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @stack('scripts')
    <script>
        document.addEventListener('livewire:load', function(e) {
                    window.livewire.on('showAlert', (data) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.msg,
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    });
                    
                    window.livewire.on('showAlertError', (data) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msg,
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    });
                })
    </script>
    @livewireScripts
</body>

</html>
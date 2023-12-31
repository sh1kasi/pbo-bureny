<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>@yield("title")</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <link href="{{ asset('template') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <script src="{{ asset('template') }}/plugins/toastr/toastr.min.js"></script>
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/toastr/toastr.css">

    <link href="{{ asset('template') }}/plugins/apexcharts/apexcharts.css" rel="stylesheet">
    <link href="{{ asset('template') }}/plugins/datepicker/css/datepicker.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/plugins/trix/trix.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/plugins/DataTables/css/jquery.dataTables.css">


    {{-- <link rel="stylesheet" href="cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css"> --}}



    <!-- Theme Styles -->
    <link href="{{ asset('template') }}/css/main.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/css/custom.css" rel="stylesheet">

    {{-- <script src="<script
src='https://code.jquery.com/jquery-3.7.0.js'
integrity='sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM='
crossorigin='anonymous'></script>"></script> --}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>

    @php
    $notif = App\Models\Pengumuman::where('user_id', auth()->user()->id)->where('status', 'belum_dibaca')->count();
    $all_pengumuman = App\Models\Pengumuman::where('user_id', auth()->user()->id)->orderBy('status', 'DESC')->get();
    @endphp

    <div class="page-container">
        <div class="page-header">
            <nav class="navbar navbar-expand-lg d-flex justify-content-between">
                <div class="" id="navbarNav">
                    <ul class="navbar-nav" id="leftNav">
                        <li class="nav-item">
                            <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-6" >
                                {{ \Carbon\Carbon::now()->translatedFormat("l, j F Y") }}
                            </a>
                        </li>
                        <div class="nav-item align-items-center d-flex ">
                            <a class="nav-link fs-6 bg-dark badge" id="jam">

                            </a>
                        </div>

                    </ul>
                </div>
                <div class="logo">
                    <a class="navbar-brand" href="index.html"></a>
                </div>
                <div class="" id="headerNav">
                    <ul class="navbar-nav">
                        {{-- <li class="nav-item dropdown">
                        <a class="nav-link search-dropdown" href="#" id="searchDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="search"></i></a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg search-drop-menu" aria-labelledby="searchDropDown">
                          <form>
                            <input class="form-control" type="text" placeholder="Type something.." aria-label="Search">
                          </form>
                          <h6 class="dropdown-header">Recent Searches</h6>
                          <a class="dropdown-item" href="#">charts</a>
                          <a class="dropdown-item" href="#">new orders</a>
                          <a class="dropdown-item" href="#">file manager</a>
                          <a class="dropdown-item" href="#">new users</a>
                        </div>
                      </li> --}}
                        @if (auth()->user()->role === "user")
                        <li class="nav-item dropdown">
                            <a class="nav-link notifications-dropdown" href="#" id="notificationsDropDown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="bell"></i></a>
                            <div class="dropdown-menu dropdown-menu-end shadow notif-drop-menu"
                                aria-labelledby="notificationsDropDown">
                                <h6 class="dropdown-header">Notifikasi</h6>
                                @foreach ($all_pengumuman as $item)
                                <a href="#"
                                    onclick="navbarPengumuman({{ $item->id }}, '{{ route('read_pengumuman', $item->id) }}')">
                                    <div class="header-notif" id="navbar_read_bg_{{ $item->id }}"
                                        style="{{ $item->status === 'belum_dibaca' ? 'background-color: #e4f0ff' : '' }}">
                                        <div class="notif-image">
                                            <span class="notification-badge bg-info text-white">
                                                <i data-feather="message-square"></i>
                                            </span>
                                        </div>
                                        <div class="notif-text position-relative">
                                            @if ($item->status === "belum_dibaca")
                                            <span id="navbar_notif_{{ $item->id }}"
                                                class="position-absolute top-50 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"
                                                style="background-color: red !important">
                                                <span class="visually-hidden">New alerts</span>
                                            </span>
                                            @endif
                                            <p class="bold-notif-text position-relative">
                                                {{ $item->judul }}</p>

                                            <small>
                                                @if (Carbon\Carbon::now() ===
                                                $item->created_at->translatedFormat("Y-m-d"))
                                                Hari ini, {{ $item->created_at->translatedFormat("H:i") }}
                                                @elseif (Carbon\Carbon::yesterday()->format("Y-m-d") ===
                                                $item->created_at->translatedFormat("Y-m-d"))
                                                Kemarin, {{ $item->created_at->translatedFormat("H:i") }}
                                                @else
                                                {{ $item->created_at->translatedFormat("m/d/Y") }}
                                                {{ $item->created_at->translatedFormat("H:i") }}
                                                @endif
                                            </small>

                                        </div>
                                    </div>
                                    <hr class="m-0">
                                </a>
                                @endforeach
                            </div>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><img
                                    src="{{ asset('template') }}/images/avatars/profile-image.png" alt=""></a>
                            <div class="dropdown-menu dropdown-menu-end profile-drop-menu"
                                aria-labelledby="profileDropDown">
                                {{-- <a class="dropdown-item" href="#"><i data-feather="user"></i>Profile</a> --}}

                                <div class="dropdown-item">Hai, {{ auth()->user()->name }}</div>
                                {{-- <a class="dropdown-item" href="#"><i data-feather="edit"></i>Activities<span class="badge rounded-pill bg-success">12</span></a> --}}
                                {{-- <a class="dropdown-item" href="#"><i data-feather="check-circle"></i>Tasks</a> --}}
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" href="#"><i data-feather="settings"></i>Settings</a> --}}
                                {{-- <a class="dropdown-item" href="#"><i data-feather="unlock"></i>Lock</a> --}}
                                <a  class="dropdown-item" href="#" id="btn-logout"><i
                                        data-feather="log-out"></i>Logout</a>
                                <form action="{{ route('logout') }}" method="post" id="logout">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="page-sidebar">
            <ul class="list-unstyled accordion-menu">
                <li class="sidebar-title">
                    Utama
                </li>
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                <li class="@if(Route::current()->getName() === " dashboard_index") active-page @endif">
                    <a href="{{ route('admin_dashboard_index') }}"><i data-feather="home"></i>Dashboard</a>
                </li>
                <hr>
                <li class="@if(Route::current()->getName() === " admin_meeting_index") active-page @endif">
                    <a href="{{ route('admin_meeting_index') }}"><i data-feather="book-open"></i>Master Rapat</a>
                </li>
                <li class="@if(Route::current()->getName() === " admin_user_index") active-page @endif">
                    <a href="{{ route('admin_user_index') }}"><i data-feather="users"></i>Master Anggota</a>
                </li>
                <li class="@if(Route::current()->getName() === " admin_pengumuman_index") active-page @endif">
                    <a href="{{ route('admin_pengumuman_index') }}"><i data-feather="bell"></i>Master Pengumuman</a>
                </li>
                @else
                <li class="@if(request()->is('rapat*')) active-page @endif">
                    <a href="{{ route('user_meeting_index') }}"><i data-feather="book-open"></i>Absen Rapat</a>
                </li>
                <li class="@if(request()->is('pengumuman*')) active-page @endif ">




                    <a href="{{ route('user_pengumuman_index') }}" class="position-relative">
                        <i data-feather="bell"></i>Pengumuman
                        <span id="sidebar_notif"
                            class=" position-absolute top-50 {{ $notif == 0 ? "d-none" : "" }} rounded-2 end-0 translate-middle badge bg-danger text-white"
                            style="background-color: rgb(207, 37, 37) !important">
                            {{ $notif != 0 ? $notif : "" }}
                        </span>
                    </a>

                </li>
                @endif

            </ul>
        </div>
        @yield('content')
    </div>


    </div>

    <!-- Javascripts -->
    <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="{{ asset('template') }}/plugins/dataTables/js/jquery.dataTables.js"></script>
    <script src="{{ asset('template') }}/plugins/popper/popper.min.js"></script>
    {{-- <script src="{{ asset('template') }}/plugins/toastr/toastr.min.js"></script> --}}
    <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('template') }}/plugins/unpkg/feather-icons.min.js"></script>
    <script src="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('template') }}/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('template') }}/js/main.min.js"></script>
    <script src="{{ asset('template') }}/plugins/sweet_alert/sweet_alert.js"></script>
    <script src="{{ asset('template') }}/plugins/trix/trix.js"></script>
    <script src="{{ asset('template') }}/js/pages/dashboard.js"></script>
    <script src="{{ asset('template') }}/js/pages/datatables.js"></script>
    <script src="{{ asset('template') }}/plugins/timepicker/js/timepicker.min.js"></script>
    <script src="{{ asset('template') }}/plugins/timepicker/js/timepicker.js"></script>
    <script src="{{ asset('template') }}/plugins/moment/moment.js"></script>
    <script src="{{ asset('template') }}/plugins/datepicker/js/datepicker.min.js"></script>


    <script>
        $(document).ready(function () {
            $("#btn-logout").click(function (e) {
                e.preventDefault();
                $("#logout").submit();
            });
        });

        setInterval(() => {
            const date = new Date();
            document.getElementById("jam").innerHTML = date.toLocaleTimeString();
        }, 1000);

        function navbarPengumuman(id, url) {
            let pindah = "{{ route('user_pengumuman_index') }}";
            window.location.href = pindah;
        }

    </script>

</body>

</html>

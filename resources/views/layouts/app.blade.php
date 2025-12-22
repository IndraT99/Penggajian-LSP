<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Aplikasi Penggajian')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <style>
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-error, .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-warning {
             color: #856404;
             background-color: #fff3cd;
             border-color: #ffeeba;
        }
        .menu-item .btn-danger {
            width: 100%;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                </defs>
                                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                    <g id="Mask" transform="translate(0.000000, 8.000000)">
                                        <mask id="mask-2" fill="white"><use xlink:href="#path-1"></use></mask>
                                        <use fill="#696cff" xlink:href="#path-1"></use>
                                        <g id="Path-3" mask="url(#mask-2)"><use fill="#696cff" xlink:href="#path-3"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use></g>
                                        <g id="Path-4" mask="url(#mask-2)"><use fill="#696cff" xlink:href="#path-4"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use></g>
                                    </g>
                                    <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "><use fill="#696cff" xlink:href="#path-5"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use></g>
                                    </g>
                                </g>
                                </g>
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">Penggajian</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    
                    <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    @if(auth()->user()->hasRole('admin'))
                        <li class="menu-header small text-uppercase"><span class="menu-header-text">Admin</span></li>
                        <li class="menu-item {{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Manajemen User">Manajemen User</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('admin.jabatans.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.jabatans.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                                <div data-i18n="Data Jabatan">Data Jabatan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('admin.divisis.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.divisis.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-building-house"></i>
                                <div data-i18n="Data Divisi">Data Divisi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('admin.payroll-components.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.payroll-components.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-money"></i>
                                <div data-i18n="Komponen Gaji">Komponen Gaji</div>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('staff_hrd'))
                        <li class="menu-header small text-uppercase"><span class="menu-header-text">Staff HRD</span></li>
                        <li class="menu-item {{ Request::routeIs('hrd.karyawan.*') ? 'active' : '' }}">
                            <a href="{{ route('hrd.karyawan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                                <div data-i18n="Kelola Karyawan">Kelola Karyawan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hrd.absensi.*') ? 'active' : '' }}">
                            <a href="{{ route('hrd.absensi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                                <div data-i18n="Kelola Absensi">Kelola Absensi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hrd.cuti.*') ? 'active' : '' }}">
                            <a href="{{ route('hrd.cuti.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calendar-minus"></i>
                                <div data-i18n="Kelola Cuti">Kelola Cuti</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hrd.lembur.*') ? 'active' : '' }}">
                            <a href="{{ route('hrd.lembur.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-time-five"></i>
                                <div data-i18n="Kelola Lembur">Kelola Lembur</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hrd.payroll.*') ? 'active' : '' }}">
                            <a href="{{ route('hrd.payroll.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calculator"></i>
                                <div data-i18n="Proses Gaji">Proses Gaji</div>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('staff_keuangan'))
                        <li class="menu-header small text-uppercase"><span class="menu-header-text">Staff Keuangan</span></li>
                        <li class="menu-item {{ Request::routeIs('keuangan.approval.*') ? 'active' : '' }}">
                            <a href="{{ route('keuangan.approval.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                                <div data-i18n="Approval Gaji">Approval Gaji</div>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('owner'))
                        <li class="menu-header small text-uppercase"><span class="menu-header-text">Owner</span></li>
                        <li class="menu-item {{ Request::routeIs('owner.laporan.*') ? 'active' : '' }}">
                            <a href="{{ route('owner.laporan.gaji') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                                <div data-i18n="Laporan Gaji">Laporan Gaji</div>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('karyawan'))
                        <li class="menu-header small text-uppercase"><span class="menu-header-text">Karyawan</span></li>
                        <li class="menu-item {{ Request::routeIs('karyawan.slip.*') ? 'active' : '' }}">
                            <a href="{{ route('karyawan.slip.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-receipt"></i>
                                <div data-i18n="Slip Gaji Saya">Slip Gaji Saya</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('karyawan.pengajuan-cuti.*') ? 'active' : '' }}">
                            <a href="{{ route('karyawan.pengajuan-cuti.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calendar-plus"></i>
                                <div data-i18n="Ajukan Cuti">Ajukan Cuti</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('karyawan.pengajuan-lembur.*') ? 'active' : '' }}">
                            <a href="{{ route('karyawan.pengajuan-lembur.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-timer"></i>
                                <div data-i18n="Ajukan Lembur">Ajukan Lembur</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('karyawan.komponen') ? 'active' : '' }}">
                            <a href="{{ route('karyawan.komponen') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-list-check"></i>
                                <div data-i18n="Komponen Gaji Saya">Komponen Gaji Saya</div>
                            </a>
                        </li>
                    @endif


                </ul>

            </aside>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <span class="fw-semibold fs-4">@yield('title', 'Dashboard')</span>
                            </div>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-primary">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <span class="avatar-initial rounded-circle bg-primary">
                                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                                    <small class="text-muted">
                                                        {{ auth()->user()->roles->pluck('name')->join(', ') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-log-out-circle me-2"></i>
                                                <span class="align-middle">Logout</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error') || session('payroll_errors'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                @if (session('payroll_errors'))
                                    <ul class="mb-0 mt-2">
                                        @foreach (session('payroll_errors') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>document.write(new Date().getFullYear());</script>
                                , Dibuat dengan ❤️ untuk Aplikasi Penggajian
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
                </div>
            </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip === 'function') {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg"
    data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/assets/images/logo/icon.PNG') }}">
    @include('layouts.css')
    
    <!-- Page Loader Styles -->
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-in-out;
        }

        .dark #page-loader {
            background-color: rgba(24, 24, 27, 0.95);
        }

        #page-loader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .loader-icon {
            width: 60px;
            height: 60px;
            animation: bounce 0.6s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { 
                transform: translateY(0);
            }
            50% { 
                transform: translateY(-20px);
            }
        }

        /* Loader text animation */
        .loader-text {
            margin-top: 20px;
            font-size: 16px;
            color: #64748b;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .dark .loader-text {
            color: #94a3b8;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>

<body
    class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="flex flex-col items-center justify-center">
            <img src="{{ asset('public/assets/images/logo/icon.PNG') }}" alt="Loading..." class="loader-icon">
            <div class="loader-text">Please Wait...</div>
        </div>
    </div>

    <div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

        <header id="page-topbar"
            class="ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm group-data-[layout=horizontal]:ltr:left-0 group-data-[layout=horizontal]:rtl:right-0 fixed right-0 z-[1000] left-0 print:hidden group-data-[navbar=bordered]:m-4 group-data-[navbar=bordered]:[&.is-sticky]:mt-0 transition-all ease-linear duration-300 group-data-[navbar=hidden]:hidden group-data-[navbar=scroll]:absolute group/topbar group-data-[layout=horizontal]:z-[1004]">
            @include('layouts.header')
        </header>

        @include('layouts.navbar')
        @php
        logger('Role:', [session('id_role')]);
        @endphp
        @include('content.sidebar')

        <div id="sidebar-overlay" class="absolute inset-0 z-[1002] bg-slate-500/30 hidden"></div>

        <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">

            <div
                class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">

                @yield('content')
            </div>

            <footer
                class="bg-topbar ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm absolute right-0 bottom-0 px-4 h-14 group-data-[layout=horizontal]:ltr:left-0  group-data-[layout=horizontal]:rtl:right-0 left-0 border-t py-3 flex items-center dark:border-zink-600">
                @include('layouts.footer')
            </footer>

        </div>

    </div>

    @include('layouts.setting')

    @include('layouts.script')

    <!-- Page Loader Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('page-loader');
            
            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                setTimeout(function() {
                    loader.classList.add('fade-out');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 300);
                }, 500);
            });

            // Show loader when navigating to another page
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                
                // Check if it's an internal link (not external, not #, not javascript:)
                if (link && 
                    link.href && 
                    !link.href.startsWith('javascript:') && 
                    !link.href.startsWith('#') &&
                    !link.target === '_blank' &&
                    link.hostname === window.location.hostname) {
                    
                    loader.style.display = 'flex';
                    loader.classList.remove('fade-out');
                }
            });

            // Handle browser back/forward buttons
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    loader.classList.add('fade-out');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 300);
                }
            });
        });
    </script>

</body>

</html>
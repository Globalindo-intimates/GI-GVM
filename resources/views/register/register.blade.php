<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg"
    data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Sign Up | GI-GVM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Template Laravel 12 PT. Globalindo Intimates" name="description">
    <meta content="MIS Team" name="author">

    <link rel="shortcut icon" href="{{ asset('public/assets/images/logo/icon.PNG') }}">
    <link href="{{ asset('public/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('public/assets/js/layout.js') }}"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/tailwind2.css') }}">
    <script src="{{ asset('public/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body class="font-public">

    <div
        class="relative flex flex-col md:flex-row w-full overflow-hidden bg-gradient-to-r from-custom-900 to-custom-800 dark:from-custom-950 dark:to-custom-900">
        <!-- Left: Login Card -->
        <div
            class="min-h-[calc(100vh_-_theme('spacing.4')_*_2)] mx-3 md:w-[28rem] lg:w-[40rem] shrink-0 px-6 md:px-8 lg:px-10 py-10 md:py-14 flex items-center justify-center m-4 bg-white rounded z-10 relative dark:bg-zink-700 dark:text-zink-100 mx-3 md:mx-auto xl:mx-4 ml-3 md:ml-0">
            <div class="flex flex-col w-full h-full">
                <div class="my-auto">
                    <!-- <img src="{{ asset('public/assets/images/logo/gi.PNG') }}" alt="Logo GI" class="block mx-auto w-[200px] h-[40px]"> -->
                    <img style="width:400px;height:60px" src="{{ asset('public/assets/images/logo/gi.PNG') }}" alt=""
                        class="block mx-auto h-7">
                    <h6 class="text-center">Jl. Jombor - Pokak 01/01, Ceper, Klaten</h6>
                    <h6 class="text-center">Jawa Tengah - Indonesia</h6>

                    <div class="lg:w-[25rem] mx-auto">
                        <div class="mt-5 tab-content">
                            <div class="block tab-pane" id="emailLogin">
                                <form action="{{ url('auth/sign_up') }}" method="POST" class="mt-10" id="signUpForm">
                                    @csrf
                                    <!-- Flash Messages -->
                                    <div class="flashMsg">
                                        @if (session('msg'))
                                            <div
                                                class="p-3 mb-3 text-base text-red-500 border border-red-200 rounded-md bg-red-50">
                                                {{ session('msg') }}
                                            </div>
                                        @endif
                                        @if (session('msgOut'))
                                            <div
                                                class="p-3 mb-3 text-base text-green-500 border border-green-200 rounded-md bg-green-50">
                                                {{ session('msgOut') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Username -->
                                    <div class="mb-3">
                                        <label for="username"
                                            class="inline-block mb-2 text-base font-medium">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Masukkan Username"  required>
                                        <div id="username-error" class="hidden mt-1 text-sm text-red-500">Please enter username</div>
                                    </div>

                                    <!-- Nama Lengkap -->
                                    <div class="mb-3">
                                        <label for="nama" class="inline-block mb-2 text-base font-medium">Nama
                                            Lengkap</label>
                                        <input type="text" id="nama" name="nama"
                                            class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Masukkan Nama Lengkap"  required>
                                        <div id="username-error" class="hidden mt-1 text-sm text-red-500">Please enter full name</div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password"
                                            class="inline-block mb-2 text-base font-medium">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Masukkan Password" required>
                                        <div id="password-error" class="hidden mt-1 text-sm text-red-500">Please enter password</div>
                                    </div>

                                    <!-- Department -->
                                    <div class="mb-3">
                                        <label for="department"
                                            class="inline-block mb-2 text-base font-medium">Department</label>

                                        <ul
                                            class="grid grid-cols-2 gap-x-4 gap-y-2 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                            <!-- MIS -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-mis" type="radio" value="MIS"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-mis"
                                                        class="ml-2 text-sm font-medium">MIS</label>
                                                </div>
                                            </li>

                                            <!-- GA -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-ga" type="radio" value="GA" name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-ga"
                                                        class="ml-2 text-sm font-medium">GA</label>
                                                </div>
                                            </li>

                                            <!-- Factory -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-factory" type="radio" value="Factory"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-factory"
                                                        class="ml-2 text-sm font-medium">Factory</label>
                                                </div>
                                            </li>

                                            <!-- Production -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-production" type="radio" value="Production"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-production"
                                                        class="ml-2 text-sm font-medium">Production</label>
                                                </div>
                                            </li>

                                            <!-- Warehouse -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-warehouse" type="radio" value="Warehouse"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-warehouse"
                                                        class="ml-2 text-sm font-medium">Warehouse</label>
                                                </div>
                                            </li>

                                            <!-- QC -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-qc" type="radio" value="QC" name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-qc"
                                                        class="ml-2 text-sm font-medium">QC</label>
                                                </div>
                                            </li>

                                            <!-- HR -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-hr" type="radio" value="HR" name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-hr"
                                                        class="ml-2 text-sm font-medium">HR</label>
                                                </div>
                                            </li>

                                            <!-- PPIC -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-ppic" type="radio" value="PPIC"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-ppic"
                                                        class="ml-2 text-sm font-medium">PPIC</label>
                                                </div>
                                            </li>

                                            <!-- Accounting -->
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="department-accounting" type="radio" value="Accounting"
                                                        name="department"
                                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="department-accounting"
                                                        class="ml-2 text-sm font-medium">Accounting</label>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                    <!-- Sign In Button -->
                                    <div class="mt-10">
                                        <button type="button"
                                            id ="signup-btn" class="w-full text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 focus:bg-custom-600 focus:ring focus:ring-custom-100 dark:ring-custom-400/20">
                                            Sign Up
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-5">
                    <p class="mb-0 text-center text-sm text-slate-500 dark:text-zink-200">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> MIS Team.
                        <a href="http://themesdesign.in" target="_blank"
                            class="underline transition-all duration-200 ease-linear text-slate-800 dark:text-zink-50 hover:text-custom-500">
                            PT Globalindo Intimates
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Branding + Animation -->
        <div
            class="relative z-10 flex items-center justify-center min-h-screen px-6 md:px-8 lg:px-10 text-center grow py-10 md:py-14">
            <div>
                <img src="{{ asset('public/assets/images/logo/logo-gi-transparant.png') }}" alt="Logo GI"
                    class="block mx-auto w-20 h-[70px]">
                <div class="mt-2 text-center">
                    <h2 class="mt-4 mb-3 capitalize text-custom-50">General Vehicle Maintenance</h2>
                    <p class="max-w-2xl mx-auto text-custom-300 text-base">Engineered by MIS PT.Globalindo Intimates</p>
                </div>

                <lottie-player
                    src="{{ asset('public/assets/images/logo/login.json') }}"
                    speed="1"
                    style="width: 450px; height: 450px"
                    loop
                    autoplay
                    direction="1"
                    mode="normal"
                    class="mx-auto">
                </lottie-player>
            </div>
        </div>
    </div>
    <script>
    const signupBtn = document.getElementById('signup-btn');

    signupBtn.addEventListener('click', function () {
        const username = document.getElementById('username').value.trim();
        const nama = document.getElementById('nama').value.trim();
        const password = document.getElementById('password').value.trim();
        const department = document.querySelector('input[name="department"]:checked');

        // Validasi form wajib diisi
        if (username === '' || nama === '' || password === '' || !department) {
            Swal.fire({
                title: 'Oops! You missed something',
                text: 'Please fill out all fields.',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Validasi ke server apakah username sudah digunakan
        let url = "{{ url('/auth/validate') }}" + '?username=' + encodeURIComponent(username);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    // Username sudah digunakan
                    Swal.fire({
                        title: 'Oops! That username’s taken',
                        text: 'Please choose a different one.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Retry'
                    });
                    return;
                } else {
                    // Username tersedia → langsung submit & tampilkan SweetAlert sukses
                    Swal.fire({
                        title: 'Your account has been successfully created!!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        document.getElementById('signUpForm').submit();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Oops! Something went wrong',
                    text: 'We couldn’t complete your registration. Please try again in a few minutes.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
    });
</script>
    <script src="{{ asset('public/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('public/assets/libs/lucide/umd/lucide.js') }}"></script>
    <script src="{{ asset('public/assets/js/tailwick.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
</body>

</html>
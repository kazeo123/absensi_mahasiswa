{{--
<!doctype html>
<html lang="en">

@include('layout.mobile.head')

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('/mobile/assets/img/sample/photo/vector4.png') }}" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>Absensi</h1>
                <h4>Login dengan Akun Anda</h4>
            </div>
            <div class="section mt-1 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="nik" class="form-control" id="inputUser" placeholder="NIK...">
                            <span class="text-danger error-text username_error" id="username_error"></span>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" name="password" id="inputPassword"
                                placeholder="Password...">
                            <span class="text-danger error-text password_error" id="password_error"></span>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn_login">Log in</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
    @include('layout.mobile.footer')
    <script>
        $(document).ready(function() {
            login();
        });
        function login() {
            $('#btn_login').click(function(e) {
                e.preventDefault();
                var username = $('#inputUser').val();
                var password = $('#inputPassword').val();

                if (!username || !password) {
                    $('#username_error').text('Nik Tidak Boleh Kosong');
                    $('#password_error').text('Password Tidak Boleh Kosong');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '/login_user',
                    data: {
                        username: username,
                        password: password,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        localStorage.setItem('auth_token', data.token);
                        window.location.href = '/dashboard';

                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Password atau Username Salah.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        } else {
                            console.log(xhr.responseJSON.message || 'Terjadi kesalahan.');
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan pada server.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });
        }
    </script>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Absensi</title>
    <!-- Favicon-->
    <link rel="icon" href="/template/img/core-img/favicon.ico">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="/template/style.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/2.0/LineIcons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only">Loading...</div>
        </div>
    </div>

    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <!-- Shape-->
        <div class="login-shape">
            <img src="/template/img/core-img/login.png" alt="">
        </div>
        <div class="login-shape2">
            <img src="/template/img/core-img/login2.png" alt="">
        </div>

        <div class="container">
            <!-- Login Text-->
            <div class="login-text text-center">
                <img class="login-img" src="img/bg-img/12.png" alt="">
                <h3 class="mb-0">E - Absensi</h3>
                <!-- Shapes-->
                <div class="bg-shapes">
                    <div class="shape1"></div>
                    <div class="shape2"></div>
                    <div class="shape3"></div>
                    <div class="shape4"></div>
                    <div class="shape5"></div>
                    <div class="shape6"></div>
                    <div class="shape7"></div>
                    <div class="shape8"></div>
                </div>
            </div>

            <!-- Register Form-->
            <div class="register-form mt-5 px-3">
                <form>
                    <div class="form-group text-left mb-4">
                        <label for="username">
                            <i class="lni lni-user"></i>
                        </label>
                        <input class="form-control" id="inputUser" type="text" name="username" placeholder="Username"
                            autocomplete="off">
                        <span class="text-danger error-text username_error" id="username_error"></span>
                    </div>
                    <div class="form-group text-left mb-4">
                        <label for="password">
                            <i class="lni lni-lock"></i>
                        </label>
                        <input class="form-control" id="inputPassword" type="password" name="password"
                            placeholder="Password">
                        <span class="text-danger error-text password_error" id="password_error"></span>
                    </div>
                    <button type="button" class="btn btn-primary btn-lg w-100" id="btn_login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- All JavaScript Files-->
    <script src="/template/js/jquery.min.js"></script>
    <script src="/template/js/popper.min.js"></script>
    <script src="/template/js/bootstrap.min.js"></script>
    <script src="/template/js/waypoints.min.js"></script>
    <script src="/template/js/jquery.easing.min.js"></script>
    <script src="/template/js/owl.carousel.min.js"></script>
    <script src="/template/js/jquery.animatedheadline.min.js"></script>
    <script src="/template/js/jquery.counterup.min.js"></script>
    <script src="/template/js/wow.min.js"></script>
    <script src="/template/js/date-clock.js"></script>
    <script src="/template/js/dark-mode-switch.js"></script>
    <script src="/template/js/active.js"></script>
    <script>
        $(document).ready(function() {
                login();
            });
            function login() {
                $('#btn_login').click(function(e) {
                    e.preventDefault();
                    var username = $('#inputUser').val();
                    var password = $('#inputPassword').val();

                    if (!username || !password) {
                        $('#username_error').text('Nik Tidak Boleh Kosong');
                        $('#password_error').text('Password Tidak Boleh Kosong');
                        return;
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/login_user',
                        data: {
                            username: username,
                            password: password,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            localStorage.setItem('auth_token', data.token);
                            window.location.href = '/dashboard';

                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Password atau Username Salah.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            } else {
                                console.log(xhr.responseJSON.message || 'Terjadi kesalahan.');
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan pada server.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            }
                        }
                    });
                });
            }
    </script>
</body>

</html>

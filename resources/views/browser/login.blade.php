<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/falcon/v3.23.0/pages/authentication/card/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Feb 2025 04:36:17 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

@include('layout.browser.head')

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="/browser/assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img
                        class="bg-auth-circle-shape-2" src="/browser/assets/img/icons/spot-illustrations/shape-1.png"
                        alt="" width="150">
                    <div class="card overflow-hidden z-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7" data-bs-theme="light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url(/browser/assets/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="z-1 position-relative"><a
                                                class="link-light mb-4 font-sans-serif fs-5 d-inline-block fw-bolder"
                                                href="/browser/index.html">E-Absensi</a>
                                            <img src="/gps.png" width="200px" alt="">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <h3>Login E-Absensi</h3>
                                            </div>
                                        </div>
                                        <form id="form-login">
                                            <div class="mb-3"><label class="form-label"
                                                    for="inputUser">Username</label><input class="form-control"
                                                    id="inputUser" type="text" placeholder="Username..."
                                                    autocomplete="off" />
                                                <span class="text-danger error-text username_error"
                                                    id="username_error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between"><label class="form-label"
                                                        for="inputPassword">Password</label></div><input
                                                    class="form-control" id="inputPassword" type="password"
                                                    placeholder="Password..." autocomplete="off" />
                                                <span class="text-danger error-text password_error"
                                                    id="password_error"></span>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3"
                                                    type="submit" name="submit" id="btn_login">Log in</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layout.browser.footer')
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
                            url: '/login_admin',
                            data: {
                                username: username,
                                password: password,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                localStorage.setItem('auth_token', data.token);
                                window.location.href = '/dashboard_admin';

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

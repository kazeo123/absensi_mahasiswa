<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/falcon/v3.23.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Feb 2025 04:27:35 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

@include('layout.browser.head')

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
            </script>

            @include('layout.browser.header')
            <div class="content">
                @include('layout.browser.menu')

                <script>
                    var navbarPosition = localStorage.getItem('navbarPosition');
            var navbarVertical = document.querySelector('.navbar-vertical');
            var navbarTopVertical = document.querySelector('.content .navbar-top');
            var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav');
            var navbarDoubleTop = document.querySelector('[data-double-top-nav]');
            var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');

            if (localStorage.getItem('navbarPosition') === 'double-top') {
              document.documentElement.classList.toggle('double-top-nav-layout');
            }

            if (navbarPosition === 'top') {
              navbarTop.removeAttribute('style');
              navbarTopVertical.remove(navbarTopVertical);
              navbarVertical.remove(navbarVertical);
              navbarTopCombo.remove(navbarTopCombo);
              navbarDoubleTop.remove(navbarDoubleTop);
            } else if (navbarPosition === 'combo') {
              navbarVertical.removeAttribute('style');
              navbarTopCombo.removeAttribute('style');
              navbarTop.remove(navbarTop);
              navbarTopVertical.remove(navbarTopVertical);
              navbarDoubleTop.remove(navbarDoubleTop);
            } else if (navbarPosition === 'double-top') {
              navbarDoubleTop.removeAttribute('style');
              navbarTopVertical.remove(navbarTopVertical);
              navbarVertical.remove(navbarVertical);
              navbarTop.remove(navbarTop);
              navbarTopCombo.remove(navbarTopCombo);
            } else {
              navbarVertical.removeAttribute('style');
              navbarTopVertical.removeAttribute('style');
              navbarTop.remove(navbarTop);
              navbarDoubleTop.remove(navbarDoubleTop);
              navbarTopCombo.remove(navbarTopCombo);
            }
                </script>
                @yield('konten')
                <footer class="footer">
                    <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">&copy; Copyright e-absensi <span class="d-none d-sm-inline-block">|
                                </span><br class="d-sm-none" /> 2024
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">v1.0.0</p>
                        </div>
                    </div>
                </footer>
            </div>
            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"
                aria-labelledby="authentication-modal-label" aria-hidden="true">
                <div class="modal-dialog mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-1">
                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                                <p class="fs-10 mb-0 text-white">Please create your free Falcon account</p>
                            </div>
                            <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                                    data-bs-dismiss="modal" aria-label="Close"></button></div>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>
                                <div class="mb-3"><label class="form-label" for="modal-auth-name">Name</label><input
                                        class="form-control" type="text" autocomplete="on" id="modal-auth-name" /></div>
                                <div class="mb-3"><label class="form-label" for="modal-auth-email">Email
                                        address</label><input class="form-control" type="email" autocomplete="on"
                                        id="modal-auth-email" /></div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6"><label class="form-label"
                                            for="modal-auth-password">Password</label><input class="form-control"
                                            type="password" autocomplete="on" id="modal-auth-password" /></div>
                                    <div class="mb-3 col-sm-6"><label class="form-label"
                                            for="modal-auth-confirm-password">Confirm Password</label><input
                                            class="form-control" type="password" autocomplete="on"
                                            id="modal-auth-confirm-password" /></div>
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        id="modal-auth-register-checkbox" /><label class="form-label"
                                        for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a
                                            class="white-space-nowrap" href="#!">privacy policy</a></label></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">Register</button></div>
                            </form>
                            <div class="position-relative mt-5">
                                <hr />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"
                                        href="#"><span class="fab fa-google-plus-g me-2"
                                            data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"
                                        href="#"><span class="fab fa-facebook-square me-2"
                                            data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @include('layout.browser.footer')
</body>


<!-- Mirrored from prium.github.io/falcon/v3.23.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Feb 2025 04:32:17 GMT -->

</html>
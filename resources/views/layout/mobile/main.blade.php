<!doctype html>
<html lang="en">

@include('layout.mobile.head')

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->



    <!-- App Capsule -->
    @yield('konten')

    <!-- * App Capsule -->
    <!-- App Bottom Menu -->
    @include('layout.mobile.menu')
    @include('layout.mobile.footer')

</body>

</html>

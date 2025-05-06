<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icon.png">
    {{--
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"> --}}
    <link rel="manifest" href="/browser/assets/img/favicons/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <script src="/browser/assets/js/config.js"></script>
    <script src="/browser/vendors/simplebar/simplebar.min.js"></script>
    <link rel="preconnect" href="../../../fonts.gstatic.com/index.html">

    <link
        href="../../../fonts.googleapis.com/css4e0a.css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="/browser/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="/browser/vendors/choices/choices.min.css" rel="stylesheet">
    <link href="/browser/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="/browser/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="/browser/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="/browser/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css" rel="stylesheet">

</head>

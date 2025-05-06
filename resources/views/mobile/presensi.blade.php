@extends('layout.mobile.main')
@section('konten')
<style>
    .webcame-capture,
    .webcame-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 200px;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/browser/assets/js/face-api.min.js"></script>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">E - Presensi</div>
    <div class="right">
        <a href="#" id="switchCamera" class="headerButton goBack">
            <ion-icon name="camera-reverse-outline"></ion-icon>

        </a>
    </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule">


    <div class="row" style="margin-top: 70px;">

        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcame-capture"> </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($cek == 0)
            <button id="takeabsen" class="btn btn-primary btn-block">
                <ion-icon name="camera-outline"></ion-icon> Absen Masuk
            </button>
            @else
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon> Absen Pulang
            </button>
            @endif
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <audio id="notifikasi_in">
        <source src="{{ asset('notif_in.mp3') }}" type="audio/mpeg">
        </source>
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('notif_out.mp3') }}" type="audio/mpeg">
        </source>
    </audio>

</div>
@endsection

@push('myscript')
<script>
    var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        var isFrontCamera = true;

        function setCamera() {
            Webcam.set({
                height: 480,
                width: 640,
                image_format: 'jpeg',
                jpeg_quality: 80,
                flip_horiz: isFrontCamera,
                constraints: {
                    facingMode: isFrontCamera ? "user" : "environment"
                }
            });
            Webcam.attach('.webcame-capture');
        }

        setCamera();

        document.getElementById('switchCamera').addEventListener('click', function() {
            isFrontCamera = !isFrontCamera;
            setCamera();
        });

        var lokasi = document.getElementById('lokasi');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var latitude = {{ explode(',', $lokasi->lokasi)[0] }};
            var longitude = {{ explode(',', $lokasi->lokasi)[1] }};
            var area = {{ $lokasi->area }};
            var circle = L.circle([latitude, longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: area
            }).addTo(map);
        }

        function errorCallback() {}

        document.addEventListener("DOMContentLoaded", async () => {
            console.log("Memuat model...");
            await loadModels();
        });

        async function loadModels() {
            try {
                await faceapi.nets.tinyFaceDetector.loadFromUri(
                    '/model');
                await faceapi.nets.faceLandmark68Net.loadFromUri(
                    '/model');
                await faceapi.nets.faceRecognitionNet.loadFromUri(
                    '/model');

                console.log("Model siap digunakan.");
            } catch (error) {
                console.error("Gagal memuat model:", error);
            }
        }

        async function compareImages(imageUpload) {
            try {
                const img = await faceapi.bufferToImage(imageUpload);
                const imageDB = await faceapi.fetchImage("{{ asset('storage/' . $foto) }}");

                const options = new faceapi.TinyFaceDetectorOptions();

                const detections1 = await faceapi.detectSingleFace(img, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                const detections2 = await faceapi.detectSingleFace(imageDB, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detections1 || !detections2) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Wajah tidak terdeteksi dalam salah satu gambar!",
                        icon: 'error',
                        timer: 3800,
                        showConfirmButton: false,
                    });
                    return false;
                }

                // Gunakan FaceMatcher dengan threshold lebih ketat (0.5)
                const faceMatcher = new faceapi.FaceMatcher(detections1, 0.5);
                const bestMatch = faceMatcher.findBestMatch(detections2.descriptor);

                console.log("Hasil perbandingan:", bestMatch);
                return bestMatch.distance < 0.5;
            } catch (error) {
                console.error("Terjadi kesalahan saat mencocokkan wajah:", error);
                return false;
            }
        }
        async function checkSpoofing(imageBlob) {
            let formData = new FormData();
            formData.append("image", imageBlob);

            let response = await fetch("http://127.0.0.1:5000/check_spoofing", {
                method: "POST",
                body: formData
            });

            let result = await response.json();
            return result;
        }

        $('#takeabsen').click(async function() {
            Swal.fire({
                title: 'Mohon Tunggu...',
                text: 'Sedang memproses wajah...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            Webcam.snap(async function(uri) {
                image = uri;
                const response = await fetch(uri);
                const blob = await response.blob();
                const isMatch = await compareImages(blob);

                const spoofCheck = await checkSpoofing(blob);
                if (spoofCheck.status !== "success") {
                    Swal.fire({
                        title: 'Gagal!',
                        text: spoofCheck.message,
                        icon: 'error',
                        timer: 3800,
                        showConfirmButton: false,
                    });
                    return false;
                }

                if (!isMatch) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Wajah tidak cocok! Anda tidak dapat melakukan absen.",
                        icon: 'error',
                        timer: 3800,
                        showConfirmButton: false,
                    });
                    return false;
                }

                var lokasi = $('#lokasi').val();
                $.ajax({
                    url: '/buat_absen',
                    type: 'POST',
                    data: {
                        image: image,
                        lokasi: lokasi
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            if (response.status_absen == 'in') {
                                notifikasi_in.play();
                            } else {
                                notifikasi_out.play();
                            }
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 3800,
                                showConfirmButton: false,
                            });
                            setTimeout(() => {
                                window.location.href = '/dashboard';
                            }, 4000);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });
        });
</script>
@endpush

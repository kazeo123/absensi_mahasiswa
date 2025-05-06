<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Recognition</title>
    <script src="browser/assets/js/face-api.min.js"></script>
</head>

<body>

    <input type="file" id="inputImage" accept="image/*">
    <canvas id="canvas"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            console.log("Memuat model...");
            await loadModels();
        });

        async function loadModels() {
            try {
                await faceapi.nets.tinyFaceDetector.loadFromUri('https://justadudewhohacks.github.io/face-api.js/models');
                await faceapi.nets.faceLandmark68Net.loadFromUri('https://justadudewhohacks.github.io/face-api.js/models');
                await faceapi.nets.faceRecognitionNet.loadFromUri('https://justadudewhohacks.github.io/face-api.js/models');

                console.log("Model siap digunakan.");
            } catch (error) {
                console.error("Gagal memuat model:", error);
            }
        }

        async function compareImages() {
            try {
                const imageUpload = document.getElementById('inputImage').files[0];
                if (!imageUpload) {
                    alert("Silakan pilih gambar terlebih dahulu!");
                    return;
                }

                const img = await faceapi.bufferToImage(imageUpload);
                const imageDB = await faceapi.fetchImage('http://127.0.0.1:8000/storage/upload/presensi/123456-19-02-2025-211235123456-19-02-2025-211235.png');

                document.body.append(img);

                const options = new faceapi.TinyFaceDetectorOptions(); // Pakai tinyFaceDetector

                const detections1 = await faceapi.detectSingleFace(img, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                const detections2 = await faceapi.detectSingleFace(imageDB, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detections1 || !detections2) {
                    alert("Wajah tidak terdeteksi dalam salah satu gambar!");
                    return;
                }

                // Gunakan FaceMatcher dengan threshold yang lebih ketat
                const faceMatcher = new faceapi.FaceMatcher(detections1, 0.5); // Gunakan 0.5 agar lebih ketat
                const bestMatch = faceMatcher.findBestMatch(detections2.descriptor);

                console.log("Hasil perbandingan:", bestMatch);

                if (bestMatch.distance < 0.5) { // Gunakan threshold lebih ketat
                    alert("Wajah cocok, meskipun ekspresi berbeda!");
                } else {
                    alert("Wajah tidak cocok!");
                }

            } catch (error) {
                console.error("Terjadi kesalahan saat mencocokkan wajah:", error);
            }
        }

        document.getElementById('inputImage').addEventListener('change', async () => {
            await compareImages();
        });

    </script>
</body>

</html>

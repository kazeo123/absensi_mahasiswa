import cv2
import numpy as np
import mediapipe as mp
from flask import Flask, request, jsonify
from flask_cors import CORS  # Import Flask-CORS

app = Flask(__name__)
CORS(app)  # Aktifkan CORS untuk semua domain

mp_face_mesh = mp.solutions.face_mesh
face_mesh = mp_face_mesh.FaceMesh()

BLUR_THRESHOLD = 50  # Toleransi blur

def detect_spoofing(image):
    # Konversi ke grayscale
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Perhitungan Laplacian untuk deteksi blur
    variance = cv2.Laplacian(gray, cv2.CV_64F).var()
    print(f"Blur Variance: {variance}")
    if variance < BLUR_THRESHOLD:
        return False, "Gambar sangat blur, coba posisikan ulang kamera!"

    # Deteksi landmark wajah
    image_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
    results = face_mesh.process(image_rgb)

    if not results.multi_face_landmarks:
        return False, "Tidak ada wajah yang terdeteksi!"

    face_landmarks = results.multi_face_landmarks[0]
    nose_tip = face_landmarks.landmark[1]
    left_eye = face_landmarks.landmark[33]
    right_eye = face_landmarks.landmark[263]
    chin = face_landmarks.landmark[199]

    nose_depth = nose_tip.z
    left_eye_depth = left_eye.z
    right_eye_depth = right_eye.z
    chin_depth = chin.z

    depth_diff = abs(nose_depth - chin_depth) + abs(left_eye_depth - right_eye_depth)
    print(f"Depth Difference: {depth_diff}")
    if depth_diff < 0.05:
        return False, "Wajah terlalu datar, kemungkinan foto cetakan!"

    brightness = np.mean(gray)
    print(f"Average Brightness: {brightness}")
    if brightness > 170:
        return False, "Cahaya berlebih terdeteksi, kemungkinan berasal dari layar!"


    hsv = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)
    saturation = hsv[:, :, 1].mean()
    print(f"Average Saturation: {saturation}")
    if saturation < 50:
        return False, "Warna tidak natural, kemungkinan wajah dari layar!"

    return True, "Wajah asli terdeteksi!"


@app.route("/check_spoofing", methods=["POST"])
def check_spoofing():
    file = request.files.get("image")
    if not file:
        return jsonify({"status": "error", "message": "Gambar tidak ditemukan"}), 400

    # Konversi gambar ke OpenCV format
    np_img = np.frombuffer(file.read(), np.uint8)
    img = cv2.imdecode(np_img, cv2.IMREAD_COLOR)

    is_real, message = detect_spoofing(img)
    return jsonify({"status": "success" if is_real else "error", "message": message})

if __name__ == "__main__":
    app.run(debug=True)

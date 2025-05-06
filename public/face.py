import cv2

# Muat model Haar Cascade yang sudah dilatih untuk deteksi wajah
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Buka kamera
cap = cv2.VideoCapture(0)

# Variabel untuk menyimpan posisi wajah dan jumlah foto yang diambil
face_positions = []
saved_photos = 0

# Fungsi untuk memeriksa apakah wajah berada di posisi yang berbeda
def is_face_position_new(new_position, positions, threshold=30):
    for pos in positions:
        if abs(new_position[0] - pos[0]) < threshold and abs(new_position[1] - pos[1]) < threshold:
            return False
    return True

while saved_photos < 3:
    # Baca frame dari video
    ret, frame = cap.read()

    # Ubah gambar menjadi grayscale
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Deteksi wajah pada gambar
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(100, 100), maxSize=(400, 400))

    # Gambar persegi di sekitar wajah yang terdeteksi dan simpan jika posisinya berbeda
    for (x, y, w, h) in faces:
        # Cek apakah posisi wajah ini baru
        if is_face_position_new((x, y), face_positions):
            # Simpan gambar dengan wajah yang terdeteksi
            saved_photos += 1
            face_positions.append((x, y))
            filename = f"face_{saved_photos}.jpg"
            cv2.imwrite(filename, frame)
            print(f"Foto {saved_photos} disimpan: {filename}")

        # Gambar kotak hanya jika wajah baru terdeteksi
        cv2.rectangle(frame, (x, y), (x+w, y+h), (255, 0, 0), 2)

        # Jika sudah 3 foto, keluar dari loop
        if saved_photos >= 3:
            break

    # Tampilkan gambar dengan wajah yang dideteksi
    cv2.imshow('Face Detection', frame)

    # Tekan 'q' untuk keluar secara manual (jika perlu)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Lepaskan kamera dan tutup semua jendela
cap.release()
cv2.destroyAllWindows()

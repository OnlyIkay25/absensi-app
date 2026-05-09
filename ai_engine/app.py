from flask import Flask, jsonify, request
from flask_cors import CORS
import face_recognition
import cv2
import numpy as np
import base64

app = Flask(__name__)
CORS(app)

@app.route('/', methods=['GET'])
def home():
    return jsonify({"status": "success", "message": "Mesin AI Aktif! 🤖"})

# ENDPOINT UNTUK DAFTAR WAJAH
@app.route('/api/encode', methods=['POST'])
def encode_face():
    try:
        data = request.json
        image_data = data['image'].split(',')[1] if ',' in data['image'] else data['image']
        img_bytes = base64.b64decode(image_data)
        np_arr = np.frombuffer(img_bytes, np.uint8)
        img = cv2.imdecode(np_arr, cv2.IMREAD_COLOR)
        rgb_img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_img)
        
        if len(face_locations) != 1:
            return jsonify({"status": "error", "message": "Wajah tidak jelas atau lebih dari 1 orang"}), 400

        face_encodings = face_recognition.face_encodings(rgb_img, face_locations)
        return jsonify({"status": "success", "embedding": face_encodings[0].tolist()})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)}), 500

# ENDPOINT UNTUK VERIFIKASI ABSEN
@app.route('/api/verify', methods=['POST'])
def verify_face():
    try:
        data = request.json
        # 1. Ambil foto dari kamera absen
        current_image = data['image'].split(',')[1] if ',' in data['image'] else data['image']
        # 2. Ambil data wajah lama dari database Laravel
        stored_embedding = np.array(data['stored_embedding'])

        img_bytes = base64.b64decode(current_image)
        np_arr = np.frombuffer(img_bytes, np.uint8)
        img = cv2.imdecode(np_arr, cv2.IMREAD_COLOR)
        rgb_img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

        face_locations = face_recognition.face_locations(rgb_img)
        if len(face_locations) == 0:
             return jsonify({"status": "error", "message": "Wajah tidak terdeteksi"}), 400

        # Ambil pola wajah dari kamera sekarang
        current_encoding = face_recognition.face_encodings(rgb_img, face_locations)[0]

        # PROSES ADU WAJAH (Tingkat toleransi 0.5 agar akurat)
        results = face_recognition.compare_faces([stored_embedding], current_encoding, tolerance=0.5)
        
        if results[0]:
            return jsonify({"status": "success", "message": "Wajah Cocok! Absensi diterima."})
        else:
            return jsonify({"status": "error", "message": "Wajah Tidak Cocok! Siapa Anda?"}), 401

    except Exception as e:
        return jsonify({"status": "error", "message": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
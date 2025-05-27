# ml_api_flask/app.py
from flask import Flask, request, jsonify
import numpy as np
import joblib # Atau library lain yang Anda gunakan untuk menyimpan model (misal: tensorflow, pytorch)
import os # Untuk memeriksa keberadaan file model

app = Flask(__name__)

# Path ke model diagnosis Anda
# Pastikan ini sesuai dengan lokasi model Anda
MODEL_DIAGNOSIS_PATH = 'models/model_svm_Diagnosis31%.pkl'
diagnosis_model = None

# Path ke model outcome Anda
MODEL_OUTCOME_PATH = 'models/model_OutcomeRF38%.pkl'
outcome_model = None

# Fungsi untuk memuat model saat aplikasi pertama kali dijalankan
def load_models():
    """
    Memuat model diagnosis dan outcome ke dalam memori aplikasi.
    Jika ada model yang gagal dimuat, aplikasi akan tetap berjalan,
    tetapi endpoint yang terkait dengan model tersebut akan mengembalikan error 500.
    """
    global diagnosis_model, outcome_model

    # Memuat model diagnosis
    if os.path.exists(MODEL_DIAGNOSIS_PATH):
        try:
            diagnosis_model = joblib.load(MODEL_DIAGNOSIS_PATH)
            print(f"Model Diagnosis berhasil dimuat dari {MODEL_DIAGNOSIS_PATH}!")
        except Exception as e:
            print(f"Gagal memuat model Diagnosis dari {MODEL_DIAGNOSIS_PATH}: {e}")
            diagnosis_model = None # Pastikan model disetel ke None jika gagal
    else:
        print(f"File model Diagnosis tidak ditemukan di: {MODEL_DIAGNOSIS_PATH}")
        diagnosis_model = None

    # Memuat model outcome
    if os.path.exists(MODEL_OUTCOME_PATH):
        try:
            outcome_model = joblib.load(MODEL_OUTCOME_PATH)
            print(f"Model Outcome berhasil dimuat dari {MODEL_OUTCOME_PATH}!")
        except Exception as e:
            print(f"Gagal memuat model Outcome dari {MODEL_OUTCOME_PATH}: {e}")
            outcome_model = None # Pastikan model disetel ke None jika gagal
    else:
        print(f"File model Outcome tidak ditemukan di: {MODEL_OUTCOME_PATH}")
        outcome_model = None

@app.route('/predict_diagnosis', methods=['POST'])
def predict_diagnosis():
    """
    Endpoint untuk memprediksi diagnosis kesehatan mental bagi pengguna tanpa login.
    Menerima data input dalam format JSON dan mengembalikan hasil diagnosis.
    """
    if not diagnosis_model:
        return jsonify({'error': 'Model diagnosis belum dimuat atau gagal dimuat.'}), 500

    data = request.get_json(force=True) # force=True akan mencoba parsing JSON meskipun Content-Type bukan application/json

    required_columns = [
        'Age', 'Gender', 'Symptom Severity (1-10)', 'Mood Score (1-10)',
        'Sleep Quality (1-10)', 'Physical Activity (hrs/week)',
        'Stress Level (1-10)', 'AI-Detected Emotional State'
    ]

    # Validasi input: pastikan semua kolom yang diperlukan ada
    for col in required_columns:
        if col not in data:
            return jsonify({'error': f'Kolom input yang diperlukan tidak ditemukan: {col}'}), 400

    # Pastikan urutan fitur sesuai dengan yang digunakan saat melatih model
    # Penting: Urutan ini harus sama persis dengan urutan fitur yang digunakan saat melatih model Anda.
    features = [
        data['Age'],
        data['Gender'],
        data['Symptom Severity (1-10)'],
        data['Mood Score (1-10)'],
        data['Sleep Quality (1-10)'],
        data['Physical Activity (hrs/week)'],
        data['Stress Level (1-10)'],
        data['AI-Detected Emotional State']
    ]

    # Konversi list fitur menjadi numpy array dan reshape untuk prediksi
    # .reshape(1, -1) mengubah array 1D menjadi 2D (1 sampel, N fitur)
    input_data = np.array(features).reshape(1, -1)

    try:
        prediction = diagnosis_model.predict(input_data)
        # Asumsi model Anda mengembalikan diagnosis langsung (misal: 0, 1, 2, ...)
        # Mengembalikan nilai pertama dari array prediksi sebagai integer
        return jsonify({'diagnosis': int(prediction[0])})
    except Exception as e:
        # Tangani error yang terjadi selama proses prediksi
        return jsonify({'error': f'Terjadi kesalahan saat melakukan prediksi diagnosis: {e}'}), 500

@app.route('/predict_outcome', methods=['POST'])
def predict_outcome():
    """
    Endpoint untuk memprediksi outcome perawatan kesehatan mental bagi admin.
    Menerima data input dalam format JSON dan mengembalikan hasil prediksi outcome.
    """
    if not outcome_model:
        return jsonify({'error': 'Model outcome belum dimuat atau gagal dimuat.'}), 500

    data = request.get_json(force=True)

    required_columns = [
        'Diagnosis', 'Symptom Severity (1-10)', 'Mood Score (1-10)',
        'Physical Activity (hrs/week)', 'Medication', 'Therapy Type',
        'Treatment Duration (weeks)', 'Stress Level (1-10)'
    ]

    # Validasi input: pastikan semua kolom yang diperlukan ada
    for col in required_columns:
        if col not in data:
            return jsonify({'error': f'Kolom input yang diperlukan tidak ditemukan: {col}'}), 400

    # Pastikan urutan fitur sesuai dengan yang digunakan saat melatih model
    # Penting: Urutan ini harus sama persis dengan urutan fitur yang digunakan saat melatih model Anda.
    features = [
        data['Diagnosis'],
        data['Symptom Severity (1-10)'],
        data['Mood Score (1-10)'],
        data['Physical Activity (hrs/week)'],
        data['Medication'],
        data['Therapy Type'],
        data['Treatment Duration (weeks)'],
        data['Stress Level (1-10)']
    ]

    # Konversi list fitur menjadi numpy array dan reshape untuk prediksi
    input_data = np.array(features).reshape(1, -1)

    try:
        prediction = outcome_model.predict(input_data)
        # Asumsi model Anda mengembalikan prediksi outcome langsung
        # Mengembalikan nilai pertama dari array prediksi sebagai integer
        return jsonify({'outcome_prediction': int(prediction[0])})
    except Exception as e:
        # Tangani error yang terjadi selama proses prediksi
        return jsonify({'error': f'Terjadi kesalahan saat melakukan prediksi outcome: {e}'}), 500

if __name__ == '__main__':
    # Panggil fungsi load_models saat aplikasi dimulai
    load_models()
    # Jalankan Flask aplikasi di semua interface yang tersedia (0.0.0.0) pada port 5000
    # debug=True akan memberikan informasi error yang lebih detail selama pengembangan
    app.run(debug=True, host='0.0.0.0', port=5000)

# ml_api_flask/app.py
from flask import Flask, request, jsonify
import numpy as np
import joblib
import os
import pandas as pd # <--- PASTIKAN INI ADA

app = Flask(__name__)

# Path ke model diagnosis Anda
MODEL_DIAGNOSIS_PATH = 'models/model_svm_Diagnosis31%.pkl'
diagnosis_model = None

# Path ke model outcome Anda
MODEL_OUTCOME_PATH = 'models/model_OutcomeRF38%.pkl'
outcome_model = None

# =========================================================================
# === DEFINISI NAMA DAN URUTAN FITUR YANG HARUS SESUAI DENGAN DATA LATIH ===
# =========================================================================

# Untuk Model Diagnosis (misal: dari kuesioner awal)
FEATURE_NAMES_DIAGNOSIS = [
    'Age',
    'Gender',
    'Symptom Severity (1-10)',
    'Mood Score (1-10)',
    'Sleep Quality (1-10)',
    'Physical Activity (hrs/week)',
    'Stress Level (1-10)',
    'AI-Detected Emotional State'
]

# Untuk Model Outcome (dari kuesioner perkembangan)
FEATURE_NAMES_OUTCOME = [
    'Diagnosis',
    'Symptom Severity (1-10)',
    'Mood Score (1-10)',
    'Physical Activity (hrs/week)',
    'Medication',
    'Therapy Type',
    'Treatment Duration (weeks)',
    'Stress Level (1-10)'
]

# =========================================================================

def load_models():
    global diagnosis_model, outcome_model

    if os.path.exists(MODEL_DIAGNOSIS_PATH):
        try:
            diagnosis_model = joblib.load(MODEL_DIAGNOSIS_PATH)
            print(f"Model Diagnosis berhasil dimuat dari {MODEL_DIAGNOSIS_PATH}!")
            if not hasattr(diagnosis_model, 'predict'):
                print("Peringatan: Model diagnosis mungkin tidak valid atau versi scikit-learn tidak cocok.")
        except Exception as e:
            print(f"Gagal memuat model Diagnosis dari {MODEL_DIAGNOSIS_PATH}: {e}")
            diagnosis_model = None
    else:
        print(f"File model Diagnosis tidak ditemukan di: {MODEL_DIAGNOSIS_PATH}")
        diagnosis_model = None

    if os.path.exists(MODEL_OUTCOME_PATH):
        try:
            outcome_model = joblib.load(MODEL_OUTCOME_PATH)
            print(f"Model Outcome berhasil dimuat dari {MODEL_OUTCOME_PATH}!")
            if not hasattr(outcome_model, 'predict'):
                print("Peringatan: Model outcome mungkin tidak valid atau versi scikit-learn tidak cocok.")
        except Exception as e:
            print(f"Gagal memuat model Outcome dari {MODEL_OUTCOME_PATH}: {e}")
            outcome_model = None
    else:
        print(f"File model Outcome tidak ditemukan di: {MODEL_OUTCOME_PATH}")
        outcome_model = None

@app.route('/predict_diagnosis', methods=['POST'])
def predict_diagnosis():
    if not diagnosis_model:
        return jsonify({'error': 'Model diagnosis belum dimuat atau gagal dimuat.'}), 500

    data = request.get_json(force=True)
    if not data:
        return jsonify({"error": "No JSON data received."}), 400

    processed_features = []
    for col in FEATURE_NAMES_DIAGNOSIS:
        if col not in data:
            return jsonify({'error': f'Kolom input yang diperlukan tidak ditemukan untuk diagnosis: {col}'}), 400
        
        try:
            # Sesuaikan casting tipe data berdasarkan kolom
            if col == 'Age':
                processed_features.append(int(data[col]))
            elif col == 'Physical Activity (hrs/week)':
                processed_features.append(float(data[col])) # Asumsi float untuk Physical Activity di model diagnosis
            else:
                processed_features.append(int(data[col]))
        except ValueError:
            return jsonify({'error': f'Nilai tidak valid untuk kolom {col}. Harap masukkan angka.'}), 400

    # <--- PERBAIKAN UTAMA DI SINI: Gunakan Pandas DataFrame
    input_df = pd.DataFrame([processed_features], columns=FEATURE_NAMES_DIAGNOSIS)

    # --- DEBUGGING PRINTS (PENTING) ---
    print(f"\n--- DEBUG /predict_diagnosis ---")
    print(f"Received raw data: {data}")
    print(f"Input DataFrame for prediction:\n{input_df}")
    print(f"Input DataFrame columns: {input_df.columns.tolist()}")
    if hasattr(diagnosis_model, 'feature_names_in_'): # Periksa diagnosis_model
        print(f"Model was fitted with columns: {diagnosis_model.feature_names_in_.tolist()}")
    else:
        print("Model does not have 'feature_names_in_' attribute (likely fitted without explicit feature names).")
    print(f"--- END DEBUG /predict_diagnosis ---\n")
    # --- END DEBUGGING PRINTS ---

    try:
        prediction = diagnosis_model.predict(input_df) # Menggunakan input_df
        return jsonify({'diagnosis': int(prediction[0])})
    except Exception as e:
        return jsonify({'error': f'Terjadi kesalahan saat melakukan prediksi diagnosis: {e}'}), 500

@app.route('/predict_outcome', methods=['POST'])
def predict_outcome():
    if not outcome_model:
        return jsonify({'error': 'Model outcome belum dimuat atau gagal dimuat.'}), 500

    data = request.get_json(force=True)
    if not data:
        return jsonify({"error": "No JSON data received."}), 400

    processed_features = []
    for col in FEATURE_NAMES_OUTCOME:
        if col not in data:
            return jsonify({'error': f'Kolom input yang diperlukan tidak ditemukan untuk outcome: {col}'}), 400
        
        try:
            # Sesuaikan casting tipe data berdasarkan kolom
            if col == 'Physical Activity (hrs/week)':
                processed_features.append(int(data[col])) # Sesuai dengan df.info() int64
            else:
                processed_features.append(int(data[col]))
        except ValueError:
            return jsonify({'error': f'Nilai tidak valid untuk kolom {col}. Harap masukkan angka.'}), 400

    # <--- PERBAIKAN UTAMA DI SINI: Gunakan Pandas DataFrame
    input_df = pd.DataFrame([processed_features], columns=FEATURE_NAMES_OUTCOME)

    # --- DEBUGGING PRINTS (PENTING) ---
    print(f"\n--- DEBUG /predict_outcome ---")
    print(f"Received raw data: {data}")
    print(f"Input DataFrame for prediction:\n{input_df}")
    print(f"Input DataFrame columns: {input_df.columns.tolist()}")
    if hasattr(outcome_model, 'feature_names_in_'): # Periksa outcome_model
        print(f"Model was fitted with columns: {outcome_model.feature_names_in_.tolist()}")
    else:
        print("Model does not have 'feature_names_in_' attribute (likely fitted without explicit feature names).")
    print(f"--- END DEBUG /predict_outcome ---\n")
    # --- END DEBUGGING PRINTS ---

    try:
        prediction = outcome_model.predict(input_df) # Menggunakan input_df
        return jsonify({'outcome_prediction': int(prediction[0])})
    except Exception as e:
        return jsonify({'error': f'Terjadi kesalahan saat melakukan prediksi outcome: {e}'}), 500

if __name__ == '__main__':
    load_models()
    app.run(debug=True, host='0.0.0.0', port=5000)
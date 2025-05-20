from flask import Flask, request, jsonify
import joblib
import os
from pymongo import MongoClient
from datetime import datetime

app = Flask(__name__)


# === Load model ===
model_path = os.path.join('public', 'python', 'model_Logistic_Regresion32%.pkl')
with open(model_path, 'rb') as f:
    model = joblib.load(f)

# === Connect to MongoDB ===
mongo_client = MongoClient('mongodb://localhost:27017/')
db = mongo_client['mental_health_db']
collection = db['predictions']

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json

    # Ambil fitur dari body
    features = [
        data['Age'],
        1 if data['Gender'].lower() == 'male' else 0,
        data['Symptom_Severity'],
        data['Mood_Score'],
        data['Sleep_Quality'],
        data['Physical_Activity'],
        data['Medication'],
        data['Therapy_Type'],  # bisa ganti encoding sesuai training
        data['Treatment_Duration'],
        data['Stress_Level'],
        data['Outcome'],
        data['Treatment_Progress'],
        data['AI_Detected_Emotional_State'],
        data['Adherence_to_Treatment'],
    ]

    # Lakukan prediksi
    prediction = model.predict([features])[0]

    # Simpan ke MongoDB
    entry = {
        "admin_id": data['admin_id'],
        "features": {
            "Age": data['Age'],
            "Gender": data['Gender'],
            "Symptom_Severity": data['Symptom_Severity'],
            "Mood_Score": data['Mood_Score'],
            "Sleep_Quality": data['Sleep_Quality'],
            "Physical_Activity": data['Physical_Activity'],
            "Medication": data['Medication'],
            "Therapy_Type": data['Therapy_Type'],
            "Treatment_Duration": data['Treatment_Duration'],
            "Stress_Level": data['Stress_Level'],
            "Outcome": data['Outcome'],
            "Treatment_Progress": data['Treatment_Progress'],
            "AI_Detected_Emotional_State": data['AI_Detected_Emotional_State'],
            "Adherence_to_Treatment": data['Adherence_to_Treatment'],
        },
        "prediction": prediction,
        "created_at": datetime.utcnow()
    }

    collection.insert_one(entry)

    return jsonify({"status": "success", "diagnosis": prediction})


@app.route('/history/<admin_id>', methods=['GET'])
def history(admin_id):
    result = collection.find({"admin_id": admin_id})
    history = []
    for item in result:
        item['_id'] = str(item['_id'])  # convert ObjectId
        history.append(item)

    return jsonify(history)


if __name__ == '__main__':
    app.run(debug=True)

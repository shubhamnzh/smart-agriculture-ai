<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Agriculture AI</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- TensorFlow -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.10.0/dist/tf.min.js"></script>

    <!-- Teachable Machine -->
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9, #ffffff);
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        #preview {
            max-width: 100%;
            border-radius: 15px;
            margin-top: 15px;
        }
        .result-box {
            font-size: 20px;
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <!-- Title -->
    <div class="text-center mb-4">
        <h1 class="fw-bold text-success">🌿 Smart Agriculture AI</h1>
        <p class="text-muted">Plant Disease Detection using AI</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Card -->
            <div class="card p-4 text-center">

                <!-- Upload -->
                <input type="file" id="imageUpload" class="form-control mb-3" accept="image/*">

                <!-- Preview -->
                <img id="preview" style="display:none;"/>

                <!-- Button -->
                <button onclick="predict()" class="btn btn-success mt-3">
                    🔍 Predict Disease
                </button>

                <!-- Result -->
                <div id="result" class="result-box mt-4"></div>

            </div>

        </div>
    </div>

</div>

<script>

let model;

// ✅ LOAD MODEL
async function loadModel() {
    const URL = "./my_model/";

    try {
        model = await tmImage.load(URL + "model.json", URL + "metadata.json");
        console.log("Model Loaded ✅");
    } catch (error) {
        console.error("Model load error ❌", error);
    }
}

loadModel();


// ✅ IMAGE PREVIEW
document.getElementById("imageUpload").addEventListener("change", function(event) {

    const file = event.target.files[0];

    if (!file) {
        alert("Please upload image!");
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        const img = document.getElementById("preview");
        img.src = e.target.result;
        img.style.display = "block";
    };

    reader.readAsDataURL(file);
});


// ✅ PREDICT FUNCTION
async function predict() {

    if (!model) {
        alert("Model not loaded yet!");
        return;
    }

    const img = document.getElementById("preview");

    if (!img.src) {
        alert("Please upload image first!");
        return;
    }

    try {
        const prediction = await model.predict(img);

        let highest = prediction[0];

        for (let i = 1; i < prediction.length; i++) {
            if (prediction[i].probability > highest.probability) {
                highest = prediction[i];
            }
        }

        let message = "";
        let color = "success";

        if (highest.className === "Healthy") {
            message = "✅ Plant is healthy!";
            color = "success";
        } 
        else if (highest.className === "Leaf Spot") {
            message = "⚠️ Leaf Spot detected. Use fungicide.";
            color = "warning";
        } 
        else if (highest.className === "Blight") {
            message = "❌ Blight detected. Immediate care needed.";
            color = "danger";
        }

        document.getElementById("result").innerHTML = `
            <div class="alert alert-${color}">
                <strong>${highest.className}</strong><br>
                Confidence: ${(highest.probability * 100).toFixed(2)}%<br><br>
                ${message}
            </div>
        `;

    } catch (error) {
        console.error("Prediction error ❌", error);
    }
}

</script>

</body>
</html>

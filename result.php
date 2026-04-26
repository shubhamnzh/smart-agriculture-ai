<?php
$image = isset($_GET['img']) ? htmlspecialchars($_GET['img']) : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Agriculture AI Result</title>

    <!-- TensorFlow + Teachable Machine -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest"></script>

    <style>
        body {
            text-align: center;
            font-family: Arial;
            background: #f4f4f4;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            width: 420px;
            margin: 50px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        img {
            width: 300px;
            border-radius: 15px;
            margin-top: 10px;
        }

        #result {
            margin-top: 20px;
            font-size: 20px;
            color: green;
        }
    </style>
</head>

<body>

<div class="card">
    <h1>🌿 Smart Agriculture AI</h1>

    <!-- Uploaded Image -->
    <img id="preview" src="uploads/<?php echo $image; ?>">

    <!-- Result -->
    <div id="result">⏳ Predicting...</div>
</div>

<script>
const URL = "model/";

let model;

// ✅ Load Model
async function loadModel() {
    try {
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";

        model = await tmImage.load(modelURL, metadataURL);

        console.log("✅ Model Loaded");

        predict();

    } catch (error) {
        console.error(error);
        document.getElementById("result").innerHTML = "❌ Model load failed";
    }
}

// ✅ Prediction
async function predict() {
    try {
        const img = document.getElementById("preview");

        if (!img.complete) {
            await new Promise(resolve => img.onload = resolve);
        }

        const prediction = await model.predict(img);

        // Sort highest probability
        prediction.sort((a, b) => b.probability - a.probability);

        let top1 = prediction[0];
        let confidence = (top1.probability * 100).toFixed(2);

        // Emoji logic
        let emoji = "🌿";
        if (top1.className.toLowerCase().includes("healthy")) {
            emoji = "✅";
        } else {
            emoji = "🦠";
        }

        // Output UI
        let output = `
            <div style="font-size:22px; color:green;">

                <div style="margin-bottom:15px;">
                    <b>Prediction:</b> ${emoji} ${top1.className}
                </div>

                <div style="margin-bottom:15px;">
                    📊 <b>Confidence:</b> ${confidence}%
                </div>
        `;

        // Optional: show top 3 predictions
        output += `<br><b>🔍 Top Predictions:</b><br>`;
        prediction.slice(0,3).forEach(p => {
            output += `${p.className}: ${(p.probability * 100).toFixed(2)}%<br>`;
        });

        output += `</div>`;

        document.getElementById("result").innerHTML = output;

    } catch (error) {
        console.error(error);
        document.getElementById("result").innerHTML =
            "❌ Error: " + error.message;
    }
}

// 🚀 Start
loadModel();
</script>

</body>
</html>

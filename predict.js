const URL = "model/";

let model, maxPredictions;

// Load model
async function loadModel() {
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";

    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    console.log("✅ Model Loaded");

    predict();
}

async function predict() {
    const img = document.getElementById("preview");

    if (!img.complete) {
        await new Promise(resolve => img.onload = resolve);
    }

    const prediction = await model.predict(img);

    // Sort predictions
    prediction.sort((a, b) => b.probability - a.probability);

    let top1 = prediction[0];

    let confidence = (top1.probability * 100).toFixed(2);

    let output = `
        <div style="font-size:22px; color:green;">
            <b>Prediction:</b> ${top1.className}<br><br>
            📊 <b>Confidence:</b> ${confidence}%
        </div>
    `;

    document.getElementById("result").innerHTML = output;
}

// Start
loadModel();

<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>AI Detection</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- TensorFlow -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.10.0"></script>

<!-- Teachable Machine -->
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>

<style>
body {
    background: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef') no-repeat center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    width: 380px;
    border-radius: 20px;
    padding: 20px;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    text-align: center;
}

#preview {
    width: 100%;
    margin-top: 10px;
    border-radius: 10px;
    display: none;
}

#drop-area {
    border: 2px dashed #28a745;
    padding: 15px;
    border-radius: 10px;
    cursor: pointer;
}

#drop-area:hover {
    background: #e9f7ef;
}

#webcam-container canvas {
    border-radius: 10px;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="card">

<h4 class="text-success">🌿 AI Plant Detection</h4>

<!-- Upload -->
<div id="drop-area">
    <p>📂 Click to Upload</p>
    <input type="file" id="imageUpload" hidden>
</div>

<!-- Preview -->
<img id="preview">

<!-- Webcam -->
<div class="mt-2">
    <button class="btn btn-primary w-100" onclick="startWebcam()">📷 Start Webcam</button>
    <button class="btn btn-danger w-100 mt-2" onclick="stopWebcam()">🛑 Stop Webcam</button>
    <div id="webcam-container"></div>
</div>

<!-- Predict -->
<button onclick="predict()" class="btn btn-success mt-3 w-100">
🔍 Predict
</button>

<!-- Result -->
<div id="result" class="mt-3"></div>

</div>

<script>

let model, webcam;

// LOAD MODEL
async function loadModel(){
    const URL = "./my_model/";
    model = await tmImage.load(URL + "model.json", URL + "metadata.json");
    console.log("Model Loaded ✅");
}
loadModel();


// CLICK UPLOAD
document.getElementById("drop-area").onclick = () => {
    document.getElementById("imageUpload").click();
};

// IMAGE PREVIEW
document.getElementById("imageUpload").addEventListener("change", function(e){

    const file = e.target.files[0];

    if (!file) {
        alert("Please select image");
        return;
    }

    const reader = new FileReader();

    reader.onload = function(ev){
        let img = document.getElementById("preview");
        img.src = ev.target.result;
        img.style.display = "block";
        stopWebcam();
    };

    reader.readAsDataURL(file);
});


// START WEBCAM
async function startWebcam(){
    webcam = new tmImage.Webcam(224, 224, true);
    await webcam.setup();
    await webcam.play();
    document.getElementById("webcam-container").innerHTML = "";
    document.getElementById("webcam-container").appendChild(webcam.canvas);
}

// STOP WEBCAM
function stopWebcam(){
    if(webcam){
        webcam.stop();
        document.getElementById("webcam-container").innerHTML = "";
        webcam = null;
    }
}


// PREDICT FUNCTION
async function predict() {

    if (!model) {
        alert("Model not loaded yet");
        return;
    }

    let img = document.getElementById("preview");
    let input = null;

    if (webcam) {
        input = webcam.canvas;
    } else if (img && img.src) {
        input = img;
    } else {
        alert("Upload image or start webcam!");
        return;
    }

    try {

        let prediction = await model.predict(input);

        let best = prediction.reduce((a, b) =>
            a.probability > b.probability ? a : b
        );

        fetch("get_solution.php?disease=" + encodeURIComponent(best.className))
        .then(res => res.text())
        .then(data => {

            document.getElementById("result").innerHTML = `
            
            <div class="alert alert-success text-center mt-3">
                <h5>🌿 ${best.className}</h5>
                <p><b>Confidence:</b> ${(best.probability * 100).toFixed(2)}%</p>
            </div>

            ${data}
            `;
        });

    } catch (error) {
        console.error(error);
        alert("Prediction failed!");
    }
}

</script>

</body>
</html>

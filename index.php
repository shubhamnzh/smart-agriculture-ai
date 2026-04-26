<!DOCTYPE html>
<html>
<head>
    <title>Smart Agriculture AI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- TensorFlow -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.10.0"></script>

    <!-- Teachable Machine -->
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
</head>

<body>

<div class="app-container">

    <!-- Header -->
    <div class="header">
        <h2>🌿 AI Plant Detection</h2>
        <p>Detect Plant Diseases Instantly</p>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Upload Section -->
        <div id="drop-area">
            <p>📂 Click to Upload Leaf Image</p>
            <input type="file" id="imageUpload" hidden>
        </div>

        <!-- Image Preview -->
        <img id="preview">

        <!-- Predict Button -->
        <button onclick="predict()" class="predict-btn">
            🔍 Predict Disease
        </button>

        <!-- Result -->
        <div id="result"></div>

    </div>

    <!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="index.php">🏠 Home</a>
    <a href="history.php">📜 History</a>
    <a href="about.php">ℹ️ About</a>
</div>
</div>

<script>

let model;

// Load Model
async function loadModel() {
    try {
        const URL = "./my_model/";

        model = await tmImage.load(
            URL + "model.json",
            URL + "metadata.json"
        );

        console.log("Model Loaded Successfully");
    } catch(error){
        console.log(error);
        alert("Model loading failed");
    }
}

loadModel();


// Upload click
document.getElementById("drop-area").onclick = function(){
    document.getElementById("imageUpload").click();
};


// Image Preview
document.getElementById("imageUpload").addEventListener("change", function(e){

    const file = e.target.files[0];

    if(!file){
        alert("Please upload image");
        return;
    }

    const reader = new FileReader();

    reader.onload = function(event){
        const img = document.getElementById("preview");
        img.src = event.target.result;
        img.style.display = "block";
    }

    reader.readAsDataURL(file);

});


// Prediction Function
async function predict(){

    if(!model){
        alert("Model not loaded yet");
        return;
    }

    let img = document.getElementById("preview");

    if(!img.src){
        alert("Upload image first");
        return;
    }

    try{

        let prediction = await model.predict(img);

        let best = prediction.reduce((a,b)=>
            a.probability > b.probability ? a : b
        );

        fetch("get_solution.php?disease=" + encodeURIComponent(best.className))
        .then(res => res.text())
        .then(data => {

            document.getElementById("result").innerHTML = `
            
            <div class="result-card">
                <h3>🌿 ${best.className}</h3>
                <p><strong>Confidence:</strong> ${(best.probability*100).toFixed(2)}%</p>
            </div>

            ${data}
            `;
        });

    }catch(error){
        console.log(error);
        alert("Prediction failed");
    }

}

</script>

</body>
</html>
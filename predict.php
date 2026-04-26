<?php
if (isset($_FILES['image'])) {

    $file = $_FILES['image'];

    $name = $file['name'];
    $tmp = $file['tmp_name'];
    $size = $file['size'];
    $error = $file['error'];

    // ✅ Allowed file types
    $allowed = ['jpg', 'jpeg', 'png'];

    // Get extension
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    // ✅ Check for errors
    if ($error !== 0) {
        die("❌ Upload error!");
    }

    // ✅ Validate file type
    if (!in_array($ext, $allowed)) {
        die("❌ Only JPG, JPEG, PNG allowed!");
    }

    // ✅ Validate file size (max 5MB)
    if ($size > 5 * 1024 * 1024) {
        die("❌ File too large! Max 5MB allowed.");
    }

    // ✅ Create unique file name (avoid overwrite)
    $newName = time() . "_" . uniqid() . "." . $ext;

    // ✅ Upload path
    $uploadPath = "uploads/" . $newName;

    // ✅ Move file
    if (move_uploaded_file($tmp, $uploadPath)) {

        // Redirect to result page
        header("Location: result.php?img=" . urlencode($newName));
        exit();

    } else {
        echo "❌ Failed to upload image!";
    }
}
?>

<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    header('Location: index.php?error=No file uploaded');
    exit;
}

$file = $_FILES['file'];
$fileName = $file['name'];
$fileSize = $file['size'];
$fileTmpName = $file['tmp_name'];
$fileError = $file['error'];

// Check for upload errors
if ($fileError !== UPLOAD_ERR_OK) {
    header('Location: index.php?error=Upload failed');
    exit;
}

// Check file size
if ($fileSize > MAX_FILE_SIZE) {
    header('Location: index.php?error=File size exceeds limit');
    exit;
}

// Get file extension
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Check file extension
if (!in_array($fileExt, ALLOWED_EXTENSIONS)) {
    header('Location: index.php?error=Invalid file type');
    exit;
}

// Generate unique filename
$uniqueId = uniqid();
$uploadedFilePath = UPLOAD_DIR . $uniqueId . '.' . $fileExt;
$convertedFilePath = CONVERTED_DIR . $uniqueId . '.ifc';

// Move uploaded file
if (!move_uploaded_file($fileTmpName, $uploadedFilePath)) {
    header('Location: index.php?error=Failed to save file');
    exit;
}

// Conversion process (simulated - in reality, you'd need actual conversion libraries)
// For this demo, we'll create a simple IFC file
$ifcContent = "ISO-10303-21;\nHEADER;\nFILE_DESCRIPTION(('Converted from " . $fileName . "'),'2;1');\nFILE_NAME('" . $uniqueId . ".ifc','',(''),'','','','');\nFILE_SCHEMA(('IFC4'));\nENDSEC;\nDATA;\n/* Converted data would go here */\nENDSEC;\nEND-ISO-10303-21;";

file_put_contents($convertedFilePath, $ifcContent);

// Redirect to download page
header('Location: download.php?id=' . $uniqueId);
exit;

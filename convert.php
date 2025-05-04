# IFC File Converter System

This is a modular PHP-based file converter system with Bootstrap frontend.

## File Structure

```
project/
├── index.php
├── upload.php
├── download.php
├── config.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── sidebar.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│   │   └── script.js
├── uploads/
├── converted/
└── README.md
```

## Code Files

### config.php
```php
<?php
// Configuration file
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('CONVERTED_DIR', __DIR__ . '/converted/');
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100MB
define('ALLOWED_EXTENSIONS', ['rvt', 'dwg', 'dxf']);

// Create directories if they don't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}
if (!file_exists(CONVERTED_DIR)) {
    mkdir(CONVERTED_DIR, 0777, true);
}

// Function to clean old files
function cleanOldFiles($directory, $maxAge = 86400) {
    $files = glob($directory . '*');
    $now = time();
    
    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= $maxAge) {
                unlink($file);
            }
        }
    }
}

// Clean old files
cleanOldFiles(UPLOAD_DIR);
cleanOldFiles(CONVERTED_DIR);
```

### includes/header.php
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFC File Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-filetype-ifc"></i> IFC Converter
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
```

### includes/footer.php
```php
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; <?php echo date('Y'); ?> IFC File Converter. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
```

### includes/sidebar.php
```php
<div class="sidebar bg-light p-3">
    <h5>Supported Formats</h5>
    <ul class="list-unstyled">
        <li><i class="bi bi-file-earmark-code"></i> Revit (.rvt)</li>
        <li><i class="bi bi-file-earmark-code"></i> AutoCAD (.dwg)</li>
        <li><i class="bi bi-file-earmark-code"></i> AutoCAD (.dxf)</li>
    </ul>
    
    <h5 class="mt-4">Convert To</h5>
    <ul class="list-unstyled">
        <li><i class="bi bi-file-earmark-arrow-down"></i> IFC (.ifc)</li>
    </ul>
    
    <div class="alert alert-info mt-4">
        <small>Maximum file size: 100MB</small>
    </div>
</div>
```

### index.php
```php
<?php require_once 'config.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <h2>Upload File for Conversion</h2>
            <p>Convert your Revit and AutoCAD files to IFC format easily.</p>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
                <div class="mb-3">
                    <label for="file" class="form-label">Select File</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                    <div class="form-text">Supported formats: .rvt, .dwg, .dxf</div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Upload and Convert
                </button>
            </form>
            
            <div class="progress mt-4" style="display: none;">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
```

### upload.php
```php
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
```

### download.php
```php
<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=Invalid download link');
    exit;
}

$id = $_GET['id'];
$filePath = CONVERTED_DIR . $id . '.ifc';

if (!file_exists($filePath)) {
    header('Location: index.php?error=File not found');
    exit;
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <h2>Conversion Complete!</h2>
            <div class="alert alert-success">
                Your file has been successfully converted to IFC format.
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Download Your File</h5>
                    <p class="card-text">Your converted IFC file is ready for download.</p>
                    
                    <a href="<?php echo $filePath; ?>" download="<?php echo $id; ?>.ifc" class="btn btn-success">
                        <i class="bi bi-download"></i> Download IFC File
                    </a>
                    
                    <a href="index.php" class="btn btn-secondary ms-2">
                        Convert Another File
                    </a>
                </div>
            </div>
            
            <div class="alert alert-info mt-4">
                <small>This file will be automatically deleted after 24 hours.</small>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
```

### assets/css/style.css
```css
body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
}

.upload-form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin-top: 20px;
}

.sidebar {
    border-radius: 5px;
    min-height: 400px;
}

.sidebar h5 {
    color: #343a40;
    margin-bottom: 15px;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.progress {
    height: 25px;
}

footer {
    margin-top: auto;
}

.navbar-brand {
    font-weight: bold;
}

.card {
    margin-top: 30px;
}

.btn i {
    margin-right: 5px;
}
```

### assets/js/script.js
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.querySelector('.upload-form');
    const progressBar = document.querySelector('.progress');
    const progressBarInner = document.querySelector('.progress-bar');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            progressBar.style.display = 'block';
            
            // Simulate progress (in reality, you'd use AJAX)
            let width = 0;
            const interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width += 10;
                    progressBarInner.style.width = width + '%';
                    progressBarInner.textContent = width + '%';
                }
            }, 500);
        });
    }
    
    // File input validation
    const fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            const allowedExtensions = ['rvt', 'dwg', 'dxf'];
            const extension = file.name.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(extension)) {
                alert('Invalid file type. Please upload .rvt, .dwg, or .dxf files.');
                this.value = '';
            }
            
            if (file.size > 100 * 1024 * 1024) {
                alert('File size exceeds 100MB limit.');
                this.value = '';
            }
        });
    }
});
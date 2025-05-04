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

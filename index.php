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

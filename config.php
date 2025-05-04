<?php
// Configuration file
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('CONVERTED_DIR', __DIR__ . '/converted/');
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100MB
define('ALLOWED_EXTENSIONS', ['rvt', 'dwg', 'dxf']);

// Image paths
define('IMAGES', [
    'logo' => 'assets/images/logo.svg',
    'favicon' => 'assets/images/favicon.svg',
    'file_icons' => [
        'rvt' => 'assets/images/rvt-icon.svg',
        'dwg' => 'assets/images/dwg-icon.svg',
        'dxf' => 'assets/images/dxf-icon.svg',
        'ifc' => 'assets/images/ifc-icon.svg'
    ]
]);

// Create directories if they don't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}
if (!file_exists(CONVERTED_DIR)) {
    mkdir(CONVERTED_DIR, 0777, true);
}
if (!file_exists(__DIR__ . '/assets/images/')) {
    mkdir(__DIR__ . '/assets/images/', 0777, true);
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

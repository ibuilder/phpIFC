document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle functionality
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.querySelector('html');
    
    // Check for saved theme preference or default to light
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    updateThemeIcon(savedTheme);
    
    themeToggle.addEventListener('click', function() {
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });
    
    function updateThemeIcon(theme) {
        if (theme === 'dark') {
            themeIcon.className = 'bi bi-moon-fill';
        } else {
            themeIcon.className = 'bi bi-sun-fill';
        }
    }
    
    // File upload functionality
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

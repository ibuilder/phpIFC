# IFC File Converter System

This is a modular PHP-based file converter system that converts Revit (.rvt) and AutoCAD (.dwg/.dxf) files to IFC (.ifc) format with a Bootstrap-based frontend.

## Features

- Upload Revit (.rvt) and AutoCAD (.dwg/.dxf) files
- Convert to IFC (.ifc) format
- Bootstrap responsive design
- **Dark/Light theme toggle**
- **Custom SVG icons and logo**
- Modular PHP structure
- File size validation (max 100MB)
- Automatic file cleanup after 24 hours
- Progress bar for upload feedback
- Download confirmation page

## Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- Write permissions for upload and converted directories

## Installation

1. Clone this repository to your web server
2. Ensure the web server has write permissions for the `uploads/` and `converted/` directories
3. Place all SVG files in the `assets/images/` directory
4. Configure your web server to serve the project directory
5. Access the application through your browser

## File Structure

```
project/
├── index.php              # Main landing page with upload form
├── upload.php            # Handles file upload and conversion
├── download.php          # Confirmation and download page
├── config.php            # Configuration settings
├── includes/             # Modular components
│   ├── header.php        # HTML head and navigation
│   ├── footer.php        # Footer and script includes
│   └── sidebar.php       # Sidebar with file format info
├── assets/               # Static assets
│   ├── css/
│   │   └── style.css     # Custom styles with theme support
│   ├── js/
│   │   └── script.js     # JavaScript with theme toggle
│   └── images/           # SVG icons and logo
│       ├── logo.svg      # Application logo
│       ├── favicon.svg   # Browser favicon
│       ├── rvt-icon.svg  # Revit file icon
│       ├── dwg-icon.svg  # AutoCAD DWG icon
│       ├── dxf-icon.svg  # AutoCAD DXF icon
│       └── ifc-icon.svg  # IFC file icon
├── uploads/              # Uploaded files storage
├── converted/            # Converted IFC files storage
└── README.md             # This file
```

## New Features

### Theme Toggle
- Light/Dark mode switch in navigation bar
- Persists preference in localStorage
- Automatic theme icon switching (sun/moon)
- Dynamic styling for all components

### Custom Icons
- SVG-based file format icons
- Application logo in navigation
- Favicon for browser tab
- Better visual identity

## Usage

1. Navigate to the homepage
2. Select a .rvt, .dwg, or .dxf file to upload
3. Click "Upload and Convert"
4. Wait for conversion to complete
5. Download the converted .ifc file
6. Toggle between dark/light themes with the button in the top-right

## Configuration

Edit `config.php` to modify:
- Maximum file size
- Allowed file extensions
- File retention period
- Upload/conversion directories
- Image paths

## Security Considerations

- File types are restricted to .rvt, .dwg, and .dxf
- File size limited to 100MB
- Uploaded files are automatically deleted after 24 hours
- Unique IDs generated for each conversion

## Known Limitations

- Current implementation creates a simple IFC file structure
- Actual conversion requires integration with specialized libraries
- No support for batch file processing
- Limited error handling for conversion failures

## Roadmap

### Phase 1: Foundation (Current)
- [x] Basic file upload interface
- [x] Modular PHP structure
- [x] Bootstrap frontend
- [x] Dark/Light theme toggle
- [x] Custom SVG icons
- [x] Basic IFC file generation

### Phase 2: Core Functionality
- [ ] Integrate actual conversion libraries (e.g., IfcOpenShell)
- [ ] Support for batch file processing
- [ ] Enhanced error handling
- [ ] Conversion progress tracking

### Phase 3: Enhanced Features
- [ ] User authentication system
- [ ] File preview functionality
- [ ] Conversion history
- [ ] Email notifications
- [ ] API endpoints for integration

### Phase 4: Advanced Features
- [ ] Cloud storage integration
- [ ] Multiple output format support
- [ ] BIM model validation
- [ ] Collaborative features
- [ ] Version control for conversions

## Technical Notes

### Conversion Process

The current implementation provides a foundation for file conversion. To implement actual conversion:

1. For Revit (.rvt) files:
   - Use Autodesk Forge API or Revit SDK
   - Extract geometry and metadata
   - Write to IFC schema

2. For AutoCAD (.dwg/.dxf) files:
   - Use Open Design Alliance libraries
   - Parse drawing entities
   - Convert to IFC building elements

### Extension Points

- `includes/`: Add new components (e.g., analytics.php)
- `assets/js/`: Add conversion status monitoring
- `config.php`: Add new file format support
- Database integration for user management

## Troubleshooting

- **File not uploading**: Check PHP upload settings in php.ini
- **Permission errors**: Ensure uploads/ and converted/ are writable
- **Conversion fails**: Verify file integrity and format support
- **Missing icons**: Ensure all SVG files are in assets/images/
- **Theme not switching**: Check browser localStorage support

## License

MIT License

## Contact

For support or feature requests, please open an issue in the repository.

## Acknowledgments

- Bootstrap for responsive design
- Bootstrap Icons for iconography
- PHP community for guidance and best practices
- SVG format for scalable vector graphics
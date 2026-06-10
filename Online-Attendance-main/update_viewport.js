const fs = require('fs');
const path = require('path');

function processDir(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        if (file === 'tcpdf' || file === 'vendor' || file.includes('db_')) continue; // skip libraries
        
        const fullPath = path.join(dir, file);
        const stat = fs.statSync(fullPath);
        
        if (stat.isDirectory()) {
            processDir(fullPath);
        } else if (file.endsWith('.html') || file.endsWith('.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let updated = false;

            // Replace standard viewport with non-scalable viewport
            const viewportRegex = /<meta\s+name=["']viewport["']\s+content=["'][^"']*["']\s*\/?>/gi;
            const newViewport = '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">';
            
            if (viewportRegex.test(content)) {
                content = content.replace(viewportRegex, newViewport);
                updated = true;
            } else if (content.includes('<head>')) {
                // If it doesn't exist, inject it
                content = content.replace(/<head>/i, `<head>\n    ${newViewport}`);
                updated = true;
            }

            if (updated) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated viewport for: ${fullPath}`);
            }
        }
    }
}

processDir('.');

// Also ensure horizontal overflow is hidden in the main css file to avoid wiggling on mobile
const cssPath = 'css/style.css';
if (fs.existsSync(cssPath)) {
    let cssContent = fs.readFileSync(cssPath, 'utf8');
    if (!cssContent.includes('overflow-x: hidden')) {
        cssContent = `html, body {\n    overflow-x: hidden;\n    max-width: 100%;\n}\n\n` + cssContent;
        fs.writeFileSync(cssPath, cssContent, 'utf8');
        console.log('Added overflow-x: hidden to style.css');
    }
}

console.log('All files updated for zoom prevention and responsiveness!');

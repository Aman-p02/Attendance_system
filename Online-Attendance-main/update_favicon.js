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
            
            // Calculate depth to determine correct path to root logo.ico
            // The root is the current working directory 'Online-Attendance-main'
            const relativePath = path.relative('.', fullPath);
            const depth = relativePath.split(path.sep).length - 1;
            
            let logoPath = 'logo.ico';
            if (depth > 0) {
                logoPath = '../'.repeat(depth) + 'logo.ico';
            }

            const faviconTag = `<link rel="icon" type="image/x-icon" href="${logoPath}">`;
            
            // If the file already has some favicon links, remove them
            content = content.replace(/<link[^>]*rel=["']icon["'][^>]*>/gi, '');
            content = content.replace(/<link[^>]*rel=["']shortcut icon["'][^>]*>/gi, '');
            content = content.replace(/<link[^>]*href=["'][^"']*logo\.ico["'][^>]*>/gi, '');
            
            // Insert the correct favicon tag right after <head>
            if (content.includes('<head>')) {
                content = content.replace(/<head>/i, `<head>\n    ${faviconTag}`);
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated favicon for: ${relativePath} with path ${logoPath}`);
            }
        }
    }
}

processDir('.');
console.log('All files updated!');

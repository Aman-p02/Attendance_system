const fs = require('fs');
const path = require('path');

const manifestLink = '<link rel="manifest" href="manifest.json">';
const faviconLink = '<link rel="icon" type="image/svg+xml" href="img/smartattend_logo.svg?v=4">';
const themeMeta = '<meta name="theme-color" content="#4481eb">';
const swScript = `
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js')
        .then(reg => console.log('SW registered', reg.scope))
        .catch(err => console.error('SW registration failed', err));
    });
  }
</script>`;

function insertTag(content, tag) {
  // Insert right after <head> if not already present
  if (!content.includes(tag)) {
    return content.replace(/<head>/i, `<head>\n    ${tag}`);
  }
  return content;
}

function processDir(dir) {
  const items = fs.readdirSync(dir);
  for (const item of items) {
    const fullPath = path.join(dir, item);
    const stat = fs.statSync(fullPath);
    if (stat.isDirectory()) {
      // Skip node_modules or build directories if any
      if (item === 'node_modules' || item === 'vendor' || item === 'tcpdf') continue;
      processDir(fullPath);
    } else if (fullPath.endsWith('.html') || fullPath.endsWith('.php')) {
      let content = fs.readFileSync(fullPath, 'utf8');
      const original = content;
      content = insertTag(content, manifestLink);
      content = insertTag(content, faviconLink);
      content = insertTag(content, themeMeta);
      content = insertTag(content, swScript.trim());
      if (content !== original) {
        fs.writeFileSync(fullPath, content, 'utf8');
        console.log(`Updated PWA tags in ${fullPath}`);
      }
    }
  }
}

processDir('.');
console.log('All HTML/PHP files now contain PWA manifest, favicon, theme-color and Service Worker registration.');

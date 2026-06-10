const fs = require('fs');
const base64 = fs.readFileSync('img/new-logo.png', 'base64');
const svg = `<svg width="512" height="512" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <rect width="512" height="512" fill="white"/>
  <image href="data:image/png;base64,${base64}" x="128" y="128" height="256" width="256" />
</svg>`;
fs.writeFileSync('img/padded_new_logo.svg', svg);

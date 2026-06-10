const fs = require('fs');

let content = fs.readFileSync('index.html', 'utf8');

// 1. Remove "Elite Plan Details" / "SmartAttend Details" section
content = content.replace(/<!-- Elite Plan Details -->[\s\S]*?<\/section>/, '');

// 2. Change "Meet the Developer" to "Meet the Creator"
content = content.replace(/<h2 class="display-5 fw-bold" style="color: #292930;">Meet the Developer<\/h2>/, '<h2 class="display-5 fw-bold" style="color: #292930;">Meet the Creator</h2>');

// 3. Update the social links in the developer card
const newSocialLinks = `                            <div class="d-flex justify-content-center gap-3 social-links position-relative z-index-2">
                                <a href="https://www.linkedin.com/in/aman-prajapati-855a8a37b?utm_source=share_via&utm_content=profile&utm_medium=member_android" target="_blank" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none shadow-sm" style="width: 45px; height: 45px; background: #0077b5; transition: all 0.3s ease;">
                                    <i class="fab fa-linkedin-in fs-5"></i>
                                </a>
                                <a href="mailto:amanjp5711@gmail.com" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none shadow-sm" style="width: 45px; height: 45px; background: #ea4335; transition: all 0.3s ease;">
                                    <i class="fas fa-envelope fs-5"></i>
                                </a>
                            </div>`;

content = content.replace(/<div class="d-flex justify-content-center gap-3 social-links position-relative z-index-2">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/, newSocialLinks + '\n                        </div>\n                    </div>');


// 4. Clean up the Footer: Remove the SVG wave to fix the huge gap, fix the logo filter, update footer social icons
content = content.replace(/<!-- Footer Top Wave\/Shape -->[\s\S]*?<\/div>/, ''); // Remove the SVG wave

content = content.replace(/<img src="img\/smartattend_logo\.svg" alt="SmartAttend" style="height: 40px; filter: brightness\(0\) invert\(1\);">/, '<img src="img/smartattend_logo.svg" alt="SmartAttend" style="height: 40px; background: white; padding: 5px; border-radius: 8px;">');

const newFooterSocials = `<div class="d-flex gap-3 mt-3 mt-md-0">
                    <a href="https://www.linkedin.com/in/aman-prajapati-855a8a37b?utm_source=share_via&utm_content=profile&utm_medium=member_android" target="_blank" class="text-white opacity-75 hover-opacity-100 transition"><i class="fab fa-linkedin fs-5"></i></a>
                    <a href="mailto:amanjp5711@gmail.com" class="text-white opacity-75 hover-opacity-100 transition"><i class="fas fa-envelope fs-5"></i></a>
                </div>`;
content = content.replace(/<div class="d-flex gap-3 mt-3 mt-md-0">[\s\S]*?<\/div>/, newFooterSocials);

fs.writeFileSync('index.html', content, 'utf8');
console.log("Updated index.html successfully with user feedback!");

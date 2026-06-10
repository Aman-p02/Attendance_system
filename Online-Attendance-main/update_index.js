const fs = require('fs');

let content = fs.readFileSync('index.html', 'utf8');

// 1. Remove "How to Login?" section
content = content.replace(/<!-- What will you study in our course -->[\s\S]*?<\/section>/g, '');

// 2. Remove Carousel / Simplify Attendance section
content = content.replace(/<!-- Carousel -->\s*<section class="py-5" id="services_new">[\s\S]*?<\/section>/g, '');

// 3. Replace Developer Section
const developer_new = `    <!-- Meet the Developer Section -->
    <section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
        <!-- Decorative Background Elements -->
        <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(68,129,235,0.05); top: -50px; left: -100px; filter: blur(40px);"></div>
        <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background: rgba(4,190,254,0.05); bottom: -150px; right: -100px; filter: blur(50px);"></div>
        
        <div class="container-lg px-4 position-relative z-index-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); color: white; font-weight: 600; letter-spacing: 1px;">THE CREATOR</span>
                <h2 class="display-5 fw-bold" style="color: #292930;">Meet the Developer</h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px; font-size: 1.1rem;">The architect behind the SmartAttend Online Attendance System, combining elegant design with robust engineering.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5" data-aos="zoom-in" data-aos-delay="100">
                    <div class="developer-card position-relative p-1 rounded-4" style="background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                        <div class="bg-white rounded-4 p-5 text-center position-relative h-100 shadow-lg" style="overflow: hidden;">
                            <!-- Subtle card background pattern -->
                            <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background-image: radial-gradient(#4481eb 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="avatar-wrapper mx-auto mb-4 position-relative" style="width: 150px; height: 150px;">
                                <div class="avatar-bg position-absolute w-100 h-100 rounded-circle" style="background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); transform: scale(1.05); animation: pulse 2s infinite;"></div>
                                <div class="position-relative w-100 h-100 rounded-circle d-flex align-items-center justify-content-center bg-white shadow-sm" style="border: 4px solid white; z-index: 2;">
                                    <span style="background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 56px; font-weight: 900; font-family: 'Nunito', sans-serif;">AP</span>
                                </div>
                            </div>
                            
                            <h3 class="fw-bold mb-1" style="color: #292930; font-family: 'Nunito', sans-serif;">Aman Prajapati</h3>
                            <p class="fw-semibold mb-4" style="color: #4481eb; letter-spacing: 2px; text-transform: uppercase; font-size: 0.9rem;">Lead Developer</p>
                            
                            <p class="text-muted mb-4" style="line-height: 1.8;">
                                Passionate software engineer specializing in building modern, secure, and highly scalable web applications that solve real-world problems.
                            </p>
                            
                            <div class="d-flex justify-content-center gap-3 social-links position-relative z-index-2">
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none shadow-sm" style="width: 45px; height: 45px; background: #333; transition: all 0.3s ease;">
                                    <i class="fab fa-github fs-5"></i>
                                </a>
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none shadow-sm" style="width: 45px; height: 45px; background: #0077b5; transition: all 0.3s ease;">
                                    <i class="fab fa-linkedin-in fs-5"></i>
                                </a>
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none shadow-sm" style="width: 45px; height: 45px; background: #ea4335; transition: all 0.3s ease;">
                                    <i class="fas fa-envelope fs-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .developer-card:hover { transform: translateY(-15px) scale(1.02); }
            .developer-card:hover .avatar-wrapper { transform: scale(1.1); transition: transform 0.4s ease; }
            .social-icon:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(68,129,235, 0.4); }
                70% { box-shadow: 0 0 0 15px rgba(68,129,235, 0); }
                100% { box-shadow: 0 0 0 0 rgba(68,129,235, 0); }
            }
        </style>
    </section>`;
content = content.replace(/<!-- Know your Instructors -->[\s\S]*?<\/section>/g, developer_new);

// 4. Replace Footer
const footer_new = `    <!-- site-footer -->
    <footer id="site_footer" style="background: #1a1a24; position: relative; overflow: hidden; padding-top: 80px; padding-bottom: 20px;">
        <!-- Footer Top Wave/Shape -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; overflow: hidden; line-height: 0;">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: 100%; height: 40px; transform: rotate(180deg);">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" style="fill: #ffffff;"></path>
            </svg>
        </div>

        <div class="container-lg px-4 position-relative z-index-1 text-white">
            <div class="row mb-5 justify-content-between">
                <div class="col-12 col-md-4 mb-4 mb-md-0">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <img src="img/smartattend_logo.svg" alt="SmartAttend" style="height: 40px; filter: brightness(0) invert(1);">
                        <span style="font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 24px;">SmartAttend</span>
                    </div>
                    <p style="color: #a0a0a0; font-size: 15px; line-height: 1.8; max-width: 300px;">
                        Revolutionizing attendance tracking with a seamless, modern, and highly secure online platform. Make manual attendance a thing of the past.
                    </p>
                </div>
                
                <div class="col-6 col-md-2 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4" style="color: #fff;">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2" style="font-size: 15px;">
                        <li><a href="#" class="text-decoration-none footer-link">Home</a></li>
                        <li><a href="login/login.html" class="text-decoration-none footer-link">Teacher Login</a></li>
                        <li><a href="login/login.html" class="text-decoration-none footer-link">Student Login</a></li>
                        <li><a href="#plan_detail" class="text-decoration-none footer-link">About Project</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4" style="color: #fff;">Legal</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2" style="font-size: 15px;">
                        <li><a href="#" class="text-decoration-none footer-link">Privacy Policy</a></li>
                        <li><a href="#" class="text-decoration-none footer-link">Terms of Service</a></li>
                        <li><a href="#" class="text-decoration-none footer-link">Cookie Policy</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-3">
                    <h5 class="fw-bold mb-4" style="color: #fff;">Stay Updated</h5>
                    <p style="color: #a0a0a0; font-size: 14px;">Subscribe to our newsletter for the latest updates and features.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control border-0 shadow-none" placeholder="Email Address" style="background: #2a2a36; color: white;">
                        <button class="btn btn-primary px-3" type="button" style="background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); border: none;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary pt-4 mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="m-0 text-center text-md-start" style="color: #a0a0a0; font-size: 14px;">
                    &copy; 2026 SmartAttend. All rights reserved. <br class="d-block d-md-none"> Designed by Aman Prajapati.
                </p>
                <div class="d-flex gap-3 mt-3 mt-md-0">
                    <a href="#" class="text-white opacity-75 hover-opacity-100 transition"><i class="fab fa-twitter fs-5"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100 transition"><i class="fab fa-facebook-f fs-5"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100 transition"><i class="fab fa-instagram fs-5"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100 transition"><i class="fab fa-github fs-5"></i></a>
                </div>
            </div>
        </div>

        <style>
            .footer-link { color: #a0a0a0; transition: all 0.3s ease; }
            .footer-link:hover { color: #04befe; padding-left: 5px; }
            .hover-opacity-100:hover { opacity: 1 !important; }
            .transition { transition: all 0.3s ease; }
            .border-secondary { border-color: #333 !important; }
        </style>
    </footer>`;
content = content.replace(/<!-- site-footer -->[\s\S]*?<\/footer>/g, footer_new);

fs.writeFileSync('index.html', content, 'utf8');
console.log("Updated index.html successfully via Node.js!");

# 🎓 SmartAttend - Online Attendance System

SmartAttend is a modern, highly responsive, and Progressive Web App (PWA) designed to replace manual attendance systems in educational institutions. It allows teachers to generate dynamic OTPs for classes and enables students to mark their presence remotely and securely.

## 🚀 Features

### 👨‍🏫 For Teachers
- **OTP Generation:** Generate secure, short-lived OTPs for individual classes and subjects.
- **Live Tracking:** View the list of students who have marked their attendance in real-time.
- **Export Data:** Automatically download the final attendance sheet as a **PDF or Excel** file.
- **Auto-Sorting:** Downloaded reports are automatically sorted in increasing order of the Student Enrollment Numbers (Roll No).
- **Session Persistence:** Stay logged in without needing to enter credentials repeatedly.

### 🎓 For Students
- **OTP Submission:** Enter the OTP provided by the teacher to mark attendance.
- **Strict Validation:** 12-digit Enrollment Number validation to prevent fake accounts.
- **Duplicate Prevention:** A single enrollment number cannot be used to create multiple accounts.
- **PWA Ready:** Install the web app directly to the mobile home screen (iOS & Android) without needing the Play Store.

### 🛡️ Security & UX Enhancements
- **Anti-Inspect Script:** Disabled Right-Click, F12, Ctrl+Shift+I, and View Source to prevent casual tampering.
- **Dynamic PWA Fallbacks:** Built-in guidance for users on Redmi/Xiaomi devices or In-App browsers (WhatsApp/Instagram) to easily install the app.
- **Password Visibility Toggle:** Eye icon to view passwords during login/signup.

---

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Backend / Database:** [Supabase](https://supabase.com/) (PostgreSQL & PostgREST API)
- **Deployment:** [Netlify](https://www.netlify.com/) (Global CDN)
- **PWA:** Service Workers (`sw.js`) & Web App Manifest (`manifest.json`)

---

## 📂 Project Structure

```text
Online-Attendance/
├── index.html         # Landing Page
├── manifest.json      # PWA Configuration
├── sw.js              # Service Worker (Cache v22)
├── css/               # Global Stylesheets
├── img/               # UI Assets & PNG Icons
├── login/             # Authentication Gateway
│   ├── teacher/       # Teacher Dashboard & Logic
│   └── student/       # Student Dashboard & Logic
└── db_*.sql           # Supabase Database Migration Scripts
```

---

## ⚙️ How to Setup (Local Development)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/SmartAttend.git
   ```
2. **Setup Supabase:**
   - Create a project on [Supabase](https://supabase.com/).
   - Copy the SQL scripts from the `db_*.sql` files and run them in your Supabase SQL Editor to create the `allteacher`, `allstudent`, and `attendance` tables.
3. **Configure API Keys:**
   - Go to `login/teacher/app.js` and `login/student/app.js`.
   - Replace the `SUPABASE_URL` and `SUPABASE_KEY` variables with your own project keys.
4. **Run Locally:**
   - You can use an extension like **Live Server** in VS Code to run the project.
   - Simply open `index.html` on your localhost.

---

## 🔮 Future Scope (Version 3.0)

While this current version (Frontend + Supabase) serves as a perfect Minimum Viable Product (MVP), future plans to scale this into an Enterprise-level software include:
1. **Custom API Backend:** Building a Node.js/Express or Python middleman server to hide database keys and enforce strict server-side validation.
2. **Supabase Auth (JWT):** Migrating from local storage logic to secure Token-based authentication.
3. **Row Level Security (RLS):** Securing the database so records cannot be modified externally.
4. **Automated Notifications:** Integrating WhatsApp/SMS APIs to alert parents of absent students.

---
*Designed & Developed by [Aman Prajapati]*

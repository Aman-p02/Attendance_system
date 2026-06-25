I developed a robust, real-time attendance management system designed to eliminate proxy attendance and automate the classroom check-in process. The solution is built as a Progressive Web App (PWA), providing a native-app-like experience that works seamlessly across all devices without requiring installation from an app store.

How it Works:
Dynamic OTP Generation: Teachers generate a unique, session-specific OTP for their respective subjects.
Time-Bound Validation: To prevent remote sharing, the OTP is strictly valid for only 10 seconds.
Automated Backend Verification: The system instantly validates the OTP, correlating it with the specific student, teacher, and subject.
Real-time Attendance Status: Attendance is automatically marked as 'Present' upon successful submission within the time limit; otherwise, it is logged as 'Absent'.

Key Features & Impact:

Proxy-Free System: Eliminates the possibility of proxy attendance by enforcing strict time constraints.
Cross-Platform Access: As a PWA, it ensures high accessibility for students and faculty on any device (mobile/desktop).
Flexible Reporting: Teachers can generate and download attendance reports in PDF format for any custom date range, simplifying the review of past records.
Time Efficiency: Significantly reduces manual effort and streamlines classroom administration.

Technologies Used:
Frontend: React.js, HTML, CSS, JavaScript
Backend: Node.js
Database: Supabase (PostgreSQL)
Architecture: Progressive Web App (PWA)

You can check it out using this link 🔗 
https://systemattend.netlify.app

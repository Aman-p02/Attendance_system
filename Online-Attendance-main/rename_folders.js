const fs = require('fs');

const path = require('path');
const loginDir = path.join(__dirname, 'login');

// Rename Student -> student_temp -> student
fs.renameSync(path.join(loginDir, 'Student'), path.join(loginDir, 'student_temp'));
fs.renameSync(path.join(loginDir, 'student_temp'), path.join(loginDir, 'student'));

// Rename Teacher -> teacher_temp -> teacher
fs.renameSync(path.join(loginDir, 'Teacher'), path.join(loginDir, 'teacher_temp'));
fs.renameSync(path.join(loginDir, 'teacher_temp'), path.join(loginDir, 'teacher'));

console.log('Folders successfully renamed to lowercase!');

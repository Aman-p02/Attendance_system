-- Migration: create allTeacher table if it does not exist
CREATE TABLE IF NOT EXISTS "allTeacher" (
    "otp" VARCHAR(10) NOT NULL DEFAULT '123',
    "teacherName" VARCHAR(1000) NOT NULL,
    "username" VARCHAR(255) PRIMARY KEY,
    "teacherSub" VARCHAR(1000) NOT NULL,
    "division" VARCHAR(50),
    "semester" VARCHAR(10)
);

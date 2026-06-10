-- =========================================================================
-- MASTER SQL SCHEMA SETUP FOR ONLINE ATTENDANCE SYSTEM
-- Run this script in the Supabase SQL Editor to create/align all tables.
-- =========================================================================

-- 1. Setup 'allteacher' table
CREATE TABLE IF NOT EXISTS allteacher (
    username      VARCHAR(255) PRIMARY KEY,
    "teacherName" VARCHAR(1000) NOT NULL,
    passwords     VARCHAR(255),
    "teacherSub"  VARCHAR(1000),
    teachersub    VARCHAR(1000), -- both lowercase and camelCase for safety
    otp           VARCHAR(10) DEFAULT NULL,
    division      VARCHAR(50),
    semester      VARCHAR(10),
    session_date  VARCHAR(100) -- added to save the active session date
);

-- Ensure all necessary columns exist in 'allteacher'
ALTER TABLE allteacher
    ADD COLUMN IF NOT EXISTS passwords VARCHAR(255),
    ADD COLUMN IF NOT EXISTS teachersub VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS division VARCHAR(50),
    ADD COLUMN IF NOT EXISTS semester VARCHAR(10),
    ADD COLUMN IF NOT EXISTS session_date VARCHAR(100);

-- 2. Setup 'allstudent' table (creates both 'allstudent' and camelCase '"allStudent"' table name for compatibility)
CREATE TABLE IF NOT EXISTS allstudent (
    rollno        VARCHAR(255) PRIMARY KEY,
    "studentName" VARCHAR(1000), -- nullable for compatibility
    studentname   VARCHAR(1000), -- nullable for compatibility
    passwords     VARCHAR(255) NOT NULL,
    semester      VARCHAR(10) NOT NULL,
    division      VARCHAR(10) NOT NULL
);

-- Safely add camelCase studentName and studentname fields to 'allstudent'
ALTER TABLE allstudent
    ADD COLUMN IF NOT EXISTS "studentName" VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS studentname VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS passwords VARCHAR(255),
    ADD COLUMN IF NOT EXISTS semester VARCHAR(10),
    ADD COLUMN IF NOT EXISTS division VARCHAR(10);

-- Make sure both case-sensitive and case-insensitive versions of 'allStudent' table exist and are aligned
CREATE TABLE IF NOT EXISTS "allStudent" (
    rollno        VARCHAR(255) PRIMARY KEY,
    "studentName" VARCHAR(1000),
    studentname   VARCHAR(1000),
    passwords     VARCHAR(255) NOT NULL,
    semester      VARCHAR(10) NOT NULL,
    division      VARCHAR(10) NOT NULL
);

-- 3. Setup 'attendance' table
CREATE TABLE IF NOT EXISTS attendance (
    id SERIAL PRIMARY KEY,
    teacher_username VARCHAR(255) NOT NULL,
    rollno           VARCHAR(255) NOT NULL,
    "studentName"    VARCHAR(1000),
    studentname      VARCHAR(1000), -- both camelCase and lowercase for safety
    subject          VARCHAR(1000),
    created_at       TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()) NOT NULL
);

-- Safely update 'attendance' table columns
ALTER TABLE attendance
    ADD COLUMN IF NOT EXISTS "studentName" VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS studentname VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS subject VARCHAR(1000);

-- 4. Disable RLS on all tables to allow public client-side operations (extremely helpful for standard JS Client key flow)
ALTER TABLE allteacher DISABLE ROW LEVEL SECURITY;
ALTER TABLE allstudent DISABLE ROW LEVEL SECURITY;
ALTER TABLE "allStudent" DISABLE ROW LEVEL SECURITY;
ALTER TABLE attendance DISABLE ROW LEVEL SECURITY;

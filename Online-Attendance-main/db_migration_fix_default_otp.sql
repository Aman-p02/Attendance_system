-- Fix: Reset all default '123' OTP values to NULL
-- This prevents students from using '123' as a valid OTP
-- Run this once in Supabase SQL Editor

UPDATE "allTeacher" SET "otp" = NULL WHERE "otp" = '123';

-- Also update the column default for future inserts
ALTER TABLE "allTeacher" ALTER COLUMN "otp" SET DEFAULT NULL;
ALTER TABLE "allTeacher" ALTER COLUMN "otp" DROP NOT NULL;

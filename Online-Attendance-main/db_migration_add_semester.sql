-- Migration: add `semester` column to the `allTeacher` table
ALTER TABLE allTeacher
ADD COLUMN semester VARCHAR(10);   -- Adjust length/type as needed

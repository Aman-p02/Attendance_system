-- Migration: add missing columns to allteacher
ALTER TABLE allteacher
    ADD COLUMN IF NOT EXISTS teacherSub VARCHAR(1000),
    ADD COLUMN IF NOT EXISTS division VARCHAR(10),
    ADD COLUMN IF NOT EXISTS semester VARCHAR(10);

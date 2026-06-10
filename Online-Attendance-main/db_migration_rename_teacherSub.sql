-- Migration: rename teachersub to "teacherSub" (preserve camel case)
ALTER TABLE allteacher RENAME COLUMN teachersub TO "teacherSub";

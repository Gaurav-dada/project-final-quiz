-- Run once on an existing `quiz` database (new installs already get this from database.sql)

ALTER TABLE `users`
  ADD `role` varchar(20) NOT NULL DEFAULT 'student';

-- the admin account (change the id if your admin is not id 1)
UPDATE `users` SET `role` = 'admin' WHERE `id` = 1;

-- =====================================================================
-- Arcade Gaming - Unified SQL Script
-- Purpose: Single, runnable script for phpMyAdmin SQL tab
-- Sources and merge sequence (preserving original order):
--   1) database.sql
-- =====================================================================

-- Target database
CREATE DATABASE IF NOT EXISTS `arcade` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `arcade`;

SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;

-- Start a transaction for DML where supported
START TRANSACTION;

-- =====================================================================
-- BEGIN: database.sql
-- =====================================================================

-- Community tables
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  text VARCHAR(500) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_comments_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_comments_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS likes (
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (post_id, user_id),
  CONSTRAINT fk_likes_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_likes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed community data
INSERT IGNORE INTO users (id, username) VALUES
(1, 'demo'),
(2, 'alice'),
(3, 'bob');

INSERT INTO posts (title, content, image_url) VALUES
('New DLC Released', 'Explore the latest expansion with new maps, weapons, and challenges.', '3.jpg'),
('Community Tournament', 'Join our weekend tournament and compete for exclusive rewards.', '4.jpg'),
('Feature Spotlight', 'Check out the new photo mode and share your best shots.', '5.jpg');

INSERT INTO comments (post_id, user_id, text) VALUES
(1, 2, 'Awesome news!'),
(1, 3, 'Can’t wait to try it.'),
(2, 2, 'I’m signing up now.'),
(3, 1, 'Photo mode looks great!');

INSERT INTO likes (post_id, user_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

-- Admin-requested tables
CREATE TABLE IF NOT EXISTS slider (
  slider_id INT AUTO_INCREMENT PRIMARY KEY,
  slider_img VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS post (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  post_img VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS user (
  username VARCHAR(50) PRIMARY KEY,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  profile_picture VARCHAR(255) NULL,
  status ENUM('active','deactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS discount (
  discount_id INT AUTO_INCREMENT PRIMARY KEY,
  discount_amount DECIMAL(10,2) NOT NULL,
  discount_time DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin-requested tables
SHOW TABLES;
INSERT INTO slider (slider_img) VALUES
('3.jpg'),('4.jpg'),('5.jpg');

INSERT INTO post (post_img) VALUES
('3.jpg'),('4.jpg'),('5.jpg');

INSERT IGNORE INTO user (username, password, email, profile_picture, status) VALUES
('admin', '$2y$10$w3H9sLwX9Cq3m2Lr2Yx2Ee3H3l1XH1mYg8m9fCzBq0m9hZl7qfsvS', 'admin@example.com', NULL, 'active');

INSERT INTO discount (discount_amount, discount_time) VALUES
(10.00, NOW()), (25.50, DATE_ADD(NOW(), INTERVAL 7 DAY));

-- END: database.sql
-- =====================================================================

-- Commit DML
COMMIT;

-- Re-enable checks
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;

-- =====================================================================
-- Quick verification
-- =====================================================================
SHOW TABLES;
SELECT 
  (SELECT COUNT(*) FROM slider) AS slider_rows,
  (SELECT COUNT(*) FROM posts)  AS posts_rows,
  (SELECT COUNT(*) FROM `user`) AS user_rows,
  (SELECT COUNT(*) FROM discount) AS discount_rows,
  (SELECT COUNT(*) FROM comments) AS comments_rows,
  (SELECT COUNT(*) FROM likes) AS likes_rows;

-- =====================================================================
-- Consolidate into users_new and posts_new, then drop old user/users and post/posts
-- =====================================================================
USE `arcade`;
SET @OLD_FKC = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;

-- Create consolidated tables
CREATE TABLE IF NOT EXISTS users_new (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  email VARCHAR(100) NULL,
  profile_picture VARCHAR(255) NULL,
  status ENUM('active','deactive') NOT NULL DEFAULT 'active',
  phone VARCHAR(20) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts_new (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  CONSTRAINT fk_posts_new_user FOREIGN KEY (user_id) REFERENCES users_new(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX IF NOT EXISTS idx_users_new_status ON users_new(status);
CREATE INDEX IF NOT EXISTS idx_posts_new_user ON posts_new(user_id);
CREATE INDEX IF NOT EXISTS idx_posts_new_created ON posts_new(created_at);

-- Migrate users -> users_new (preserve IDs)
INSERT INTO users_new (id, username, password_hash, email, profile_picture, status, phone, created_at, updated_at)
SELECT u.id, u.username, u.password_hash, NULL, NULL, 'active', NULL, u.created_at, NULL
FROM users u
WHERE NOT EXISTS (SELECT 1 FROM users_new sn WHERE sn.id = u.id);

-- Migrate admin user -> users_new (assign new IDs, avoid username duplicates)
INSERT INTO users_new (username, password_hash, email, profile_picture, status, phone, created_at, updated_at)
SELECT a.username, a.password, a.email, a.profile_picture, a.status, NULL, a.created_at, NULL
FROM `user` a
WHERE NOT EXISTS (SELECT 1 FROM users_new sn WHERE sn.username = a.username);

-- Migrate posts -> posts_new (preserve IDs)
INSERT INTO posts_new (id, user_id, title, content, image_url, created_at, updated_at)
SELECT p.id, NULL, p.title, p.content, p.image_url, p.created_at, NULL
FROM posts p
WHERE NOT EXISTS (SELECT 1 FROM posts_new pn WHERE pn.id = p.id);

-- Migrate admin post -> posts_new (image-only posts)
INSERT INTO posts_new (user_id, title, content, image_url, created_at, updated_at)
SELECT NULL, 'Image Post', '', ap.post_img, NOW(), NULL
FROM `post` ap
WHERE ap.post_img IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM posts_new pn WHERE pn.image_url = ap.post_img);

-- Update FKs to point to new consolidated tables
ALTER TABLE comments DROP FOREIGN KEY fk_comments_post;
ALTER TABLE comments DROP FOREIGN KEY fk_comments_user;
ALTER TABLE likes DROP FOREIGN KEY fk_likes_post;
ALTER TABLE likes DROP FOREIGN KEY fk_likes_user;

ALTER TABLE comments
  ADD CONSTRAINT fk_comments_post_new FOREIGN KEY (post_id) REFERENCES posts_new(id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_comments_user_new FOREIGN KEY (user_id) REFERENCES users_new(id) ON DELETE CASCADE;

ALTER TABLE likes
  ADD CONSTRAINT fk_likes_post_new FOREIGN KEY (post_id) REFERENCES posts_new(id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_likes_user_new FOREIGN KEY (user_id) REFERENCES users_new(id) ON DELETE CASCADE;

-- Drop old tables
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `post`;
DROP TABLE IF EXISTS `posts`;

SET FOREIGN_KEY_CHECKS = @OLD_FKC;

-- Verify result
SHOW TABLES;
SELECT 
  (SELECT COUNT(*) FROM users_new) AS users_new_rows,
  (SELECT COUNT(*) FROM posts_new) AS posts_new_rows,
  (SELECT COUNT(*) FROM comments) AS comments_rows,
  (SELECT COUNT(*) FROM likes) AS likes_rows;

-- =====================================================================
-- Simplify schema: remove ALL foreign keys, merge into *_new tables,
-- handle missing source tables gracefully, and drop old tables.
-- No foreign keys will remain.
-- =====================================================================
USE `arcade`;
SET FOREIGN_KEY_CHECKS = 0;

-- Create simplified consolidated tables (no foreign keys)
CREATE TABLE IF NOT EXISTS users_new (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  email VARCHAR(100) NULL,
  profile_picture VARCHAR(255) NULL,
  status ENUM('active','deactive') NOT NULL DEFAULT 'active',
  phone VARCHAR(20) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts_new (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Conditional merge from existing tables using dynamic SQL
SET @exists_users = (SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='arcade' AND TABLE_NAME='users');
SET @sql_users = IF(@exists_users>0,
'INSERT INTO users_new (id, username, password_hash, created_at)
 SELECT u.id, u.username, u.password_hash, u.created_at FROM users u
 WHERE NOT EXISTS (SELECT 1 FROM users_new sn WHERE sn.id = u.id);',
'DO 0');
PREPARE s1 FROM @sql_users; EXECUTE s1; DEALLOCATE PREPARE s1;

SET @exists_user = (SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='arcade' AND TABLE_NAME='user');
SET @sql_user = IF(@exists_user>0,
'INSERT INTO users_new (username, password_hash, email, profile_picture, status, created_at)
 SELECT a.username, a.password, a.email, a.profile_picture, a.status, a.created_at FROM `user` a
 WHERE NOT EXISTS (SELECT 1 FROM users_new sn WHERE sn.username = a.username);',
'DO 0');
PREPARE s2 FROM @sql_user; EXECUTE s2; DEALLOCATE PREPARE s2;

SET @exists_posts = (SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='arcade' AND TABLE_NAME='posts');
SET @sql_posts = IF(@exists_posts>0,
'INSERT INTO posts_new (id, user_id, title, content, image_url, created_at)
 SELECT p.id, NULL, p.title, p.content, p.image_url, p.created_at FROM posts p
 WHERE NOT EXISTS (SELECT 1 FROM posts_new pn WHERE pn.id = p.id);',
'DO 0');
PREPARE s3 FROM @sql_posts; EXECUTE s3; DEALLOCATE PREPARE s3;

SET @exists_post = (SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='arcade' AND TABLE_NAME='post');
SET @sql_post = IF(@exists_post>0,
'INSERT INTO posts_new (user_id, title, content, image_url, created_at)
 SELECT NULL, \"Image Post\", \"\", ap.post_img, NOW() FROM `post` ap
 WHERE ap.post_img IS NOT NULL
   AND NOT EXISTS (SELECT 1 FROM posts_new pn WHERE pn.image_url = ap.post_img);',
'DO 0');
PREPARE s4 FROM @sql_post; EXECUTE s4; DEALLOCATE PREPARE s4;

-- Drop ALL foreign keys in the schema (dynamic)
DELIMITER //
CREATE PROCEDURE drop_all_fks(IN sch VARCHAR(64))
BEGIN
  DECLARE done INT DEFAULT 0;
  DECLARE t VARCHAR(64);
  DECLARE c VARCHAR(64);
  DECLARE cur CURSOR FOR
    SELECT TABLE_NAME, CONSTRAINT_NAME
    FROM information_schema.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA=sch AND CONSTRAINT_TYPE='FOREIGN KEY';
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
  OPEN cur;
  read_loop: LOOP
    FETCH cur INTO t, c;
    IF done = 1 THEN LEAVE read_loop; END IF;
    SET @sql = CONCAT('ALTER TABLE `', sch, '`.`', t, '` DROP FOREIGN KEY `', c, '`');
    PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;
  END LOOP;
  CLOSE cur;
END//
DELIMITER ;
CALL drop_all_fks('arcade');
DROP PROCEDURE drop_all_fks;

-- Drop old tables safely (they may or may not exist)
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `post`;
DROP TABLE IF EXISTS `posts`;

SET FOREIGN_KEY_CHECKS = 1;

-- Verify simplified schema
SHOW TABLES;
SELECT 
  (SELECT COUNT(*) FROM users_new) AS users_new_rows,
  (SELECT COUNT(*) FROM posts_new) AS posts_new_rows;

-- =====================================================================
-- Compatibility views to fix runtime code expecting `users` and `posts`
-- =====================================================================
CREATE OR REPLACE VIEW users AS
SELECT id, username, password_hash, email, profile_picture, status, phone, created_at, updated_at
FROM users_new;

CREATE OR REPLACE VIEW posts AS
SELECT id, user_id, title, content, image_url, created_at, updated_at
FROM posts_new;
-- =====================================================================
-- Merge admin tables into primary ones (no drops or alters)
-- =====================================================================
-- Merge admin users -> primary users, avoiding duplicates by username
INSERT INTO users (username, password_hash, created_at)
SELECT u.username, u.password, u.created_at
FROM `user` u
WHERE NOT EXISTS (
  SELECT 1 FROM users s WHERE s.username = u.username
);

-- Merge admin post images -> primary posts as image-only posts, dedup by image_url
INSERT INTO posts (title, content, image_url, created_at)
SELECT 'Image Post', '', p.post_img, NOW()
FROM `post` p
WHERE p.post_img IS NOT NULL
  AND NOT EXISTS (
    SELECT 1 FROM posts ps WHERE ps.image_url = p.post_img
  );


CREATE OR REPLACE VIEW users AS
SELECT id, username, password_hash, email, profile_picture, status, phone, created_at, updated_at
FROM users_new;

CREATE OR REPLACE VIEW posts AS
SELECT id, user_id, title, content, image_url, created_at, updated_at
FROM posts_new;
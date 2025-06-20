-- Membuat tabel users
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY, -- Menambahkan AUTO_INCREMENT untuk id
    `username` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `full_name` VARCHAR(100) DEFAULT NULL,
    `location` VARCHAR(100) DEFAULT NULL,
    `role` ENUM('admin', 'user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
    `gambar` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    -- Menambahkan UNIQUE constraint pada email dan username jika diperlukan
    UNIQUE (`email`),
    UNIQUE (`username`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Membuat tabel blog
CREATE TABLE IF NOT EXISTS `blog` (
    `id` INT AUTO_INCREMENT PRIMARY KEY, -- Menambahkan AUTO_INCREMENT untuk id
    `judul` VARCHAR(255) NOT NULL,
    `konten` TEXT NOT NULL,
    `gambar` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `views` INT NOT NULL DEFAULT 0,
    `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
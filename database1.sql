-- Membuat database
CREATE DATABASE IF NOT EXISTS rtrw_terpadu;
USE rtrw_terpadu;

-- 1. Tabel roles
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT
);

-- 2. Tabel kelurahan
CREATE TABLE kelurahan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel rt_rw
CREATE TABLE rt_rw (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kelurahan_id INT NOT NULL,
    rt VARCHAR(10) NOT NULL,
    rw VARCHAR(10) NOT NULL,
    name VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kelurahan_id) REFERENCES kelurahan(id) ON DELETE CASCADE,
    UNIQUE KEY (kelurahan_id, rt, rw)
);

-- 4. Tabel users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20) UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    role_id INT NOT NULL,
    rt_rw_id INT NULL,
    kelurahan_id INT NULL,
    status ENUM('pending', 'active', 'inactive', 'rejected') DEFAULT 'pending',
    verified_by INT NULL,
    verified_at TIMESTAMP NULL,
    appointed_by INT NULL,
    appointed_at TIMESTAMP NULL,
    created_by INT NULL,
    qr_token VARCHAR(255) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (rt_rw_id) REFERENCES rt_rw(id) ON DELETE SET NULL,
    FOREIGN KEY (kelurahan_id) REFERENCES kelurahan(id) ON DELETE SET NULL,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (appointed_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX (email),
    INDEX (phone),
    INDEX (qr_token)
);

-- 5. Tabel otp_codes
CREATE TABLE otp_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    code VARCHAR(6) NOT NULL,
    type ENUM('email', 'phone') NOT NULL,
    purpose ENUM('registration', 'forgot_password', 'login') NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX (user_id, code)
);

-- 6. Tabel programs
CREATE TABLE programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rt_rw_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    budget DECIMAL(15,2),
    is_funded_by_iuran BOOLEAN DEFAULT FALSE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rt_rw_id) REFERENCES rt_rw(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX (rt_rw_id)
);

-- 7. Tabel iuran_settings
CREATE TABLE iuran_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rt_rw_id INT NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    effective_date DATE NOT NULL,
    end_date DATE NULL,
    is_current BOOLEAN DEFAULT TRUE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rt_rw_id) REFERENCES rt_rw(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX (rt_rw_id, effective_date)
);

-- 8. Tabel iuran_payments
CREATE TABLE iuran_payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    month TINYINT NOT NULL,
    year SMALLINT NOT NULL,
    amount_paid DECIMAL(15,2) NOT NULL,
    paid_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    paid_by INT NOT NULL,
    payment_method ENUM('cash', 'transfer', 'other') DEFAULT 'cash',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (paid_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY (user_id, month, year),
    INDEX (user_id),
    INDEX (month, year)
);

-- 9. Tabel program_iuran_allocations
CREATE TABLE program_iuran_allocations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    program_id INT NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    effective_date DATE NOT NULL,
    end_date DATE NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX (program_id, effective_date)
);

-- 10. Tabel iuran_distributions
CREATE TABLE iuran_distributions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    month TINYINT NOT NULL,
    year SMALLINT NOT NULL,
    program_id INT NOT NULL,
    amount_allocated DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
    UNIQUE KEY (month, year, program_id),
    INDEX (month, year)
);
-- Jobsheet 10: tabel users (Petugas) untuk autentikasi

CREATE TABLE IF NOT EXISTS users (
    id       SERIAL PRIMARY KEY,
    nama     VARCHAR(255) NOT NULL,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role     VARCHAR(20)  NOT NULL DEFAULT 'petugas'
);

-- remember me 
ALTER TABLE users ADD COLUMN IF NOT EXISTS remember_token VARCHAR(64);
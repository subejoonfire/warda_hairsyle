-- Create home_content table
CREATE TABLE IF NOT EXISTS home_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    order_position INTEGER DEFAULT 1,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);

-- Create footer_content table
CREATE TABLE IF NOT EXISTS footer_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section VARCHAR(50) NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    icon VARCHAR(100),
    order_position INTEGER DEFAULT 1,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);

-- Add new columns to bookings table
ALTER TABLE bookings ADD COLUMN customer_photo VARCHAR(255);
ALTER TABLE bookings ADD COLUMN price_confirmed DECIMAL(10,2);
ALTER TABLE bookings ADD COLUMN price_status VARCHAR(20) DEFAULT 'pending';

-- Insert default home content data
INSERT INTO home_content (section, title, description, icon, order_position, is_active, created_at, updated_at) VALUES
('why_choose_us', 'Kualitas Terbaik', 'Menggunakan alat dan teknik terbaik untuk hasil maksimal', 'fas fa-star', 1, 1, datetime('now'), datetime('now')),
('why_choose_us', 'Tepat Waktu', 'Layanan cepat dan tepat waktu sesuai janji', 'fas fa-clock', 2, 1, datetime('now'), datetime('now')),
('why_choose_us', 'Barber Profesional', 'Tim barber berpengalaman dan terlatih', 'fas fa-user-tie', 3, 1, datetime('now'), datetime('now')),
('why_choose_us', 'Kepuasan Customer', 'Prioritas utama adalah kepuasan customer', 'fas fa-heart', 4, 1, datetime('now'), datetime('now')),
('services', 'Cornrow', 'Layanan cukur rambut dengan berbagai style modern dan klasik', 'fas fa-cut', 1, 1, datetime('now'), datetime('now')),
('services', 'Home Service', 'Layanan cukur rambut di rumah Anda dengan kenyamanan maksimal', 'fas fa-home', 2, 1, datetime('now'), datetime('now')),
('services', 'Boxbraid', 'Konsultasi style rambut sesuai dengan bentuk wajah Anda', 'fas fa-cut', 3, 1, datetime('now'), datetime('now'));

-- Insert default footer content data
INSERT INTO footer_content (section, title, content, icon, order_position, is_active, created_at, updated_at) VALUES
('about', 'Warda_hairstyle', 'Layanan cukur rambut terbaik dengan kualitas profesional dan harga terjangkau.', NULL, 1, 1, datetime('now'), datetime('now')),
('services', 'Layanan', '', NULL, 1, 1, datetime('now'), datetime('now')),
('services', NULL, 'Cukur Rambut', 'fas fa-cut', 2, 1, datetime('now'), datetime('now')),
('services', NULL, 'Home Service', 'fas fa-home', 3, 1, datetime('now'), datetime('now')),
('services', NULL, 'Konsultasi Style', 'fas fa-comments', 4, 1, datetime('now'), datetime('now')),
('contact', 'Kontak', '', NULL, 1, 1, datetime('now'), datetime('now')),
('contact', NULL, '+62 812-3456-7890', 'fab fa-whatsapp', 2, 1, datetime('now'), datetime('now')),
('contact', NULL, 'Jl. Contoh No. 123', 'fas fa-map-marker-alt', 3, 1, datetime('now'), datetime('now')),
('contact', NULL, '08:00 - 20:00', 'fas fa-clock', 4, 1, datetime('now'), datetime('now'));
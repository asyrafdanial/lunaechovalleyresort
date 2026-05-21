CREATE DATABASE IF NOT EXISTS luna_echo_valley;
USE luna_echo_valley;

CREATE TABLE IF NOT EXISTS resort_amenities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    operating_hours VARCHAR(100) DEFAULT '8:00 AM - 6:00 PM',
    status VARCHAR(20) DEFAULT 'Buka'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO resort_amenities (slug, name, category, description, operating_hours, status) VALUES
('moraia-suites', 'Moraia Suites Wing', 'Resort', 'Sayap penginapan utama yang menawarkan bilik-bilik mewah dengan pemandangan bukit dan hutan semulajadi.', '24 Jam (Check-in 3 PM)', 'Penuh'),
('selene-villas', 'Selene Villas', 'Resort', 'Vila eksklusif peribadi untuk tetamu yang inginkan privasi maksimum berserta kolam renang mini sendiri.', '24 Jam', 'Buka'),
('pavilion-restaurant', 'The Pavilion Restaurant', 'Resort', 'Restoran utama yang menyajikan hidangan lokal buffet dan barat dengan suasana terbuka.', '7:00 AM - 10:00 PM', 'Buka'),
('amora-spa', 'Amora Spa & Wellness Center', 'Resort', 'Pusat rawatan spa, urutan tradisional, dan terapi kesihatan untuk kesegaran tubuh badan.', '9:00 AM - 9:00 PM', 'Buka'),
('luna-hot-springs', 'Luna Natural Hot Springs', 'Resort', 'Kolam air panas semula jadi yang kaya dengan mineral untuk relaksasi optimum.', '6:00 AM - 11:00 PM', 'Buka'),
('tennis-courts', 'Tennis Courts', 'Resort', 'Gelanggang tenis standard antarabangsa terbuka untuk semua tetamu resort.', '8:00 AM - 7:00 PM', 'Buka'),
('orchid-greenhouse', 'Orchid Greenhouse', 'Eco Garden', 'Rumah hijau yang menonjolkan pelbagai spesis bunga okid hiasan dan hibrid yang unik.', '8:00 AM - 5:00 PM', 'Buka'),
('butterfly-sanctuary', 'Butterfly Sanctuary', 'Eco Garden', 'Taman rimbun yang menjadi rumah kepada ratusan spesis rama-rama tropika yang berwarna-warni.', '9:00 AM - 5:00 PM', 'Buka'),
('organic-farm', 'Organic Farm & Apiary', 'Eco Garden', 'Kawasan pertanian organik berserta pusat ternakan lebah madu kelulut asli.', '8:00 AM - 5:00 PM', 'Buka'),
('horse-stable', 'Horse Stable & Riding Trail', 'Resort', 'Aktiviti menunggang kuda mengelilingi trek laluan herba dan kaki bukit yang mendamaikan.', '8:30 AM - 6:00 PM', 'Buka');
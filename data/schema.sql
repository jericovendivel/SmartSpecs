-- ============================================================
--  SmartSpecs -- Database Schema
--  Compatible with XAMPP (utf8 / utf8_general_ci)
--  Run this file in phpMyAdmin > Import, or:
--    mysql -u root -p < data/schema.sql
-- ============================================================

SET NAMES utf8;
SET CHARACTER SET utf8;
SET character_set_connection = utf8;

CREATE DATABASE IF NOT EXISTS smartspecs
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE smartspecs;

-- ---- DROP EXISTING TABLES (clean slate) ---------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS spec_rows;
DROP TABLE IF EXISTS spec_sections;
DROP TABLE IF EXISTS phones;
DROP TABLE IF EXISTS brands;
SET FOREIGN_KEY_CHECKS = 1;

-- ---- BRANDS -------------------------------------------------
CREATE TABLE IF NOT EXISTS brands (
    id         VARCHAR(20)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL PRIMARY KEY,
    name       VARCHAR(50)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    icon       VARCHAR(10)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    tagline    VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    gradient   VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    color      VARCHAR(10)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    sort_order TINYINT      DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ---- PHONES -------------------------------------------------
CREATE TABLE IF NOT EXISTS phones (
    id         VARCHAR(50)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL PRIMARY KEY,
    brand_id   VARCHAR(20)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    name       VARCHAR(80)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    tag        VARCHAR(40)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    tagline    VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    price      VARCHAR(15)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    year       YEAR         NOT NULL,
    image      VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    colors     TEXT         CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    hl_display VARCHAR(30)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    hl_camera  VARCHAR(40)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    hl_battery VARCHAR(20)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    hl_chip    VARCHAR(60)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    sort_order TINYINT      DEFAULT 0,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ---- SPEC SECTIONS ------------------------------------------
CREATE TABLE IF NOT EXISTS spec_sections (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    phone_id   VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    title      VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    sort_order TINYINT     DEFAULT 0,
    FOREIGN KEY (phone_id) REFERENCES phones(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ---- SPEC ROWS ----------------------------------------------
CREATE TABLE IF NOT EXISTS spec_rows (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section_id INT UNSIGNED NOT NULL,
    spec_key   VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    spec_value TEXT        CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    sort_order TINYINT     DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES spec_sections(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
--  SEED DATA
-- ============================================================

-- ---- BRANDS -------------------------------------------------
INSERT INTO brands (id, name, icon, tagline, gradient, color, sort_order) VALUES
('samsung', 'Samsung', '[S]',
 'Galaxy Ecosystem - Pushing boundaries of mobile technology',
 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(30,100,255,0.3) 0%, transparent 70%)',
 '#1428A0', 1),
('apple', 'Apple', '[A]',
 'iPhone - Designed for performance, built for life',
 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(150,150,170,0.3) 0%, transparent 70%)',
 '#555555', 2),
('xiaomi', 'Xiaomi', '[X]',
 'Xiaomi - Innovation for everyone',
 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(255,60,60,0.3) 0%, transparent 70%)',
 '#FF6900', 3),
('google', 'Google', '[G]',
 'Pixel - The best of Google, in your hands',
 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(50,200,100,0.3) 0%, transparent 70%)',
 '#34A853', 4);

-- ---- SAMSUNG PHONES -----------------------------------------
INSERT INTO phones VALUES
('samsung_s25ultra','samsung','Galaxy S25 Ultra','Ultra Series',
 'Built for those who demand the absolute best.','$1,299',2025,'samsung_s25ultra.png',
 '["#2C2C2E","#B4B8C0","#D4E4CF","#C9B89A"]','6.9 inch','200MP','5000mAh','Snapdragon 8 Elite',1),

('samsung_s25plus','samsung','Galaxy S25+','Plus Series',
 'Large display. S25 power. Perfectly balanced.','$999',2025,'samsung_s25plus.png',
 '["#1C2951","#B4B8C0","#C9B89A","#D4E4CF"]','6.7 inch','50MP','4900mAh','Snapdragon 8 Elite',2),

('samsung_s25','samsung','Galaxy S25','Base Series',
 'The everyday flagship. Smarter than ever.','$799',2025,'samsung_s25.png',
 '["#ADAFC8","#C9B89A","#D4E4CF","#2C2C2E"]','6.2 inch','50MP','4000mAh','Snapdragon 8 Elite',3),

('samsung_zfold6','samsung','Galaxy Z Fold 6','Fold Series',
 'Unfold the future. A phone and a tablet in one.','$1,899',2024,'samsung_zfold6.png',
 '["#242424","#B4B4B4","#2E4B8C"]','7.6 inch','50MP','4400mAh','Snapdragon 8 Gen 3',4),

('samsung_zflip6','samsung','Galaxy Z Flip 6','Flip Series',
 'Compact icon. Flip the script on ordinary.','$1,099',2024,'samsung_zflip6.png',
 '["#E8E0F0","#3B5BDB","#F5BEB2","#1E1E1E"]','3.4 inch cover','50MP','4000mAh','Snapdragon 8 Gen 3',5),

('samsung_a55','samsung','Galaxy A55 5G','A Series',
 'Premium style. Smart value.','$449',2024,'samsung_a55.png',
 '["#2A4B8C","#C4B5A0","#1E2B1A","#1C1C1E"]','6.6 inch','50MP','5000mAh','Exynos 1480',6);

-- ---- APPLE PHONES -------------------------------------------
INSERT INTO phones VALUES
('apple_16promax','apple','iPhone 16 Pro Max','Pro Max',
 'The biggest. The boldest. Titanium perfection.','$1,199',2024,'iphone16promax.png',
 '["#2D2D2D","#F5F1EB","#A4947C","#CCDDE8"]','6.9 inch','48MP','4685mAh','A18 Pro',1),

('apple_16pro','apple','iPhone 16 Pro','Pro',
 'Pro power in a refined compact form.','$999',2024,'iphone16pro.png',
 '["#2D2D2D","#F5F1EB","#A4947C","#CCDDE8"]','6.3 inch','48MP','3582mAh','A18 Pro',2),

('apple_16plus','apple','iPhone 16 Plus','Plus',
 'Big screen. All-day battery. Simply great.','$899',2024,'iphone16plus.png',
 '["#1C1C1E","#F0F0F0","#4CA3E0","#E8D5C0","#4DC48E"]','6.7 inch','48MP','4674mAh','A18',3),

('apple_16','apple','iPhone 16','Base',
 'A fresh take on the everyday iPhone.','$799',2024,'iphone16.png',
 '["#1C1C1E","#F0F0F0","#4CA3E0","#E8D5C0","#4DC48E"]','6.1 inch','48MP','3561mAh','A18',4),

('apple_se4','apple','iPhone SE (4th gen)','SE',
 'Powerful. Affordable. The SE you have been waiting for.','$599',2025,'iphone_se4.png',
 '["#1C1C1E","#F0F0F0","#4CA3E0"]','6.1 inch','48MP','3279mAh','A18',5),

('apple_15','apple','iPhone 15','Previous Gen',
 'Dynamic Island. USB-C. Supercharged camera.','$699',2023,'iphone15.png',
 '["#F5D7B3","#7EC8E3","#FFB4C2","#A0C8A0","#1C1C1E"]','6.1 inch','48MP','3349mAh','A16 Bionic',6);

-- ---- XIAOMI PHONES ------------------------------------------
INSERT INTO phones VALUES
('xiaomi_15ultra','xiaomi','Xiaomi 15 Ultra','Ultra Series',
 'Master photography. Leica-powered brilliance.','$1,399',2025,'xiaomi15ultra.png',
 '["#1C1C1E","#E8E0D8","#2A4B8C"]','6.73 inch','200MP Leica','6000mAh','Snapdragon 8 Elite',1),

('xiaomi_15pro','xiaomi','Xiaomi 15 Pro','Pro Series',
 'Professional power meets Leica optics.','$1,099',2025,'xiaomi15pro.png',
 '["#1C1C1E","#E8E0D8","#4CA3E0"]','6.73 inch','50MP Leica','6100mAh','Snapdragon 8 Elite',2),

('xiaomi_15','xiaomi','Xiaomi 15','Base',
 'Compact powerhouse. Leica at its finest.','$899',2025,'xiaomi15.png',
 '["#1C1C1E","#E8E0D8","#4DC48E","#4CA3E0"]','6.36 inch','50MP Leica','5240mAh','Snapdragon 8 Elite',3),

('xiaomi_14ultra','xiaomi','Xiaomi 14 Ultra','Previous Ultra',
 'The photography phone redefined.','$1,299',2024,'xiaomi14ultra.png',
 '["#1C1C1E","#E8E0D8","#2A3F5F"]','6.73 inch','50MP Leica 1in','5000mAh','Snapdragon 8 Gen 3',4),

('xiaomi_mix_fold4','xiaomi','Xiaomi MIX Fold 4','Fold Series',
 'The thinnest folding flagship ever made.','$1,599',2024,'xiaomi_mixfold4.png',
 '["#1C1C1E","#F0E8D8","#2A4B8C"]','7.98 inch unfolded','50MP Leica','5100mAh','Snapdragon 8 Gen 3',5),

('xiaomi_redmi_note14pro','xiaomi','Redmi Note 14 Pro+','Redmi Series',
 'Pro performance. Everyday price.','$349',2024,'redmi_note14pro.png',
 '["#2C4EA8","#1C2B1A","#C0BAC8"]','6.67 inch','200MP','6200mAh','Snapdragon 7s Gen 3',6);

-- ---- GOOGLE PHONES ------------------------------------------
INSERT INTO phones VALUES
('google_pixel9profl','google','Pixel 9 Pro Fold','Pro Fold',
 'Google folds. AI everywhere.','$1,799',2024,'pixel9profold.png',
 '["#F0EAE2","#1C2B3A"]','8.0 inch unfolded','48MP','4650mAh','Tensor G4',1),

('google_pixel9proxl','google','Pixel 9 Pro XL','Pro XL',
 'XL size. Titan intelligence.','$1,099',2024,'pixel9proxl.png',
 '["#E8F0D8","#F0EAE2","#1C2B3A","#B8C4D0"]','6.8 inch','50MP','5060mAh','Tensor G4',2),

('google_pixel9pro','google','Pixel 9 Pro','Pro',
 'Pro cameras. Gemini AI. Compact powerhouse.','$999',2024,'pixel9pro.png',
 '["#E8F0D8","#F0EAE2","#1C2B3A","#B8C4D0"]','6.3 inch','50MP','4700mAh','Tensor G4',3),

('google_pixel9','google','Pixel 9','Base',
 'Pure Google. Smarter every day.','$799',2024,'pixel9.png',
 '["#FFF0D8","#E8E0D0","#1C2B3A","#FFAABB"]','6.3 inch','50MP','4700mAh','Tensor G4',4),

('google_pixel9a','google','Pixel 9a','A Series',
 'Amazing for less. Pixel, made accessible.','$499',2025,'pixel9a.png',
 '["#4DC48E","#E0D8F0","#F0EAE2","#1C1C1E"]','6.3 inch','48MP','5100mAh','Tensor G4',5),

('google_pixel8pro','google','Pixel 8 Pro','Prev Gen',
 'The Tensor G3 powerhouse. Now at a great price.','$699',2023,'pixel8pro.png',
 '["#E8F0D8","#1C2B3A","#E8C8D8"]','6.7 inch','50MP','5050mAh','Tensor G3',6);

-- ============================================================
--  SPEC SECTIONS + ROWS
-- ============================================================

-- ---- Samsung Galaxy S25 Ultra -------------------------------
SET @pid = 'samsung_s25ultra';
INSERT INTO spec_sections (phone_id, title, sort_order) VALUES
(@pid,'Display',1),(@pid,'Performance',2),(@pid,'Camera',3),
(@pid,'Battery & Charging',4),(@pid,'Design & Build',5),(@pid,'Connectivity',6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Display' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Screen Size',    '6.9 inches',             1),
(@s,'Technology',     'Dynamic AMOLED 2X',       2),
(@s,'Resolution',     '3088 x 1440 (QHD+)',      3),
(@s,'Refresh Rate',   '1-120Hz adaptive',        4),
(@s,'Peak Brightness','2600 nits',               5),
(@s,'Protection',     'Corning Gorilla Armor 2', 6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Performance' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Chipset','Snapdragon 8 Elite for Galaxy',               1),
(@s,'CPU',    'Octa-core (2x4.47GHz + 6x3.53GHz Oryon V2)',2),
(@s,'GPU',    'Adreno 830',                                  3),
(@s,'RAM',    '12GB LPDDR5X',                                4),
(@s,'Storage','256GB / 512GB / 1TB UFS 4.0',                 5),
(@s,'OS',     'Android 15, One UI 7',                        6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Camera' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Main Camera',  '200MP f/1.7 OIS',                 1),
(@s,'Ultrawide',    '50MP f/1.9 120 deg FOV',           2),
(@s,'Telephoto 1',  '10MP f/2.4 3x optical zoom',       3),
(@s,'Telephoto 2',  '50MP f/3.4 5x optical zoom',       4),
(@s,'Front Camera', '12MP f/2.2',                       5),
(@s,'Video',        '8K@30fps, 4K@120fps',               6),
(@s,'Features',     'AI ProVisual Engine, Nightography', 7);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Battery & Charging' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Capacity',         '5000 mAh',                   1),
(@s,'Wired Charging',   '45W fast charging',           2),
(@s,'Wireless Charging','15W Qi2',                     3),
(@s,'Reverse Wireless', '4.5W',                        4),
(@s,'Battery Life',     'Up to 27hrs video streaming', 5);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Design & Build' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Dimensions','162.8 x 77.6 x 8.2 mm',        1),
(@s,'Weight',    '218g',                           2),
(@s,'Frame',     'Titanium Grade 4',               3),
(@s,'Back',      'Corning Gorilla Glass Victus 2', 4),
(@s,'S Pen',     'Included (built-in)',             5),
(@s,'IP Rating', 'IP68 (6m, 30min)',                6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Connectivity' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'5G',       'Sub-6GHz, mmWave',     1),
(@s,'Wi-Fi',    'Wi-Fi 7 (802.11be)',   2),
(@s,'Bluetooth','5.4',                  3),
(@s,'USB',      'USB 3.2 Gen 2 Type-C', 4),
(@s,'NFC',      'Yes',                  5),
(@s,'Satellite','Emergency SOS',        6);

-- ---- iPhone 16 Pro Max --------------------------------------
SET @pid = 'apple_16promax';
INSERT INTO spec_sections (phone_id, title, sort_order) VALUES
(@pid,'Display',1),(@pid,'Performance',2),(@pid,'Camera',3),
(@pid,'Battery & Charging',4),(@pid,'Design & Build',5),(@pid,'Connectivity',6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Display' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Screen Size',    '6.9 inches',            1),
(@s,'Technology',     'Super Retina XDR OLED', 2),
(@s,'Resolution',     '2868 x 1320 (460 ppi)', 3),
(@s,'Refresh Rate',   '1-120Hz ProMotion',     4),
(@s,'Peak Brightness','2000 nits (outdoors)',   5),
(@s,'Protection',     'Ceramic Shield (front)', 6),
(@s,'Always-On',      'Yes',                    7);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Performance' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Chip',         'A18 Pro',                              1),
(@s,'CPU',          '6-core (2 performance + 4 efficiency)',2),
(@s,'GPU',          '6-core',                              3),
(@s,'Neural Engine','16-core',                             4),
(@s,'RAM',          '8GB',                                 5),
(@s,'Storage',      '256GB / 512GB / 1TB',                 6),
(@s,'OS',           'iOS 18',                              7);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Camera' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Main Camera',  '48MP f/1.78 Fusion (2nd gen)',            1),
(@s,'Ultrawide',    '48MP f/2.2 Macro Vision',                 2),
(@s,'Telephoto',    '12MP f/2.8 5x optical zoom (Tetraprism)', 3),
(@s,'Front Camera', '12MP f/1.9 autofocus',                    4),
(@s,'Video',        '4K@120fps ProRes, Dolby Vision',          5),
(@s,'Features',     'Camera Control button, AI photo editing', 6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Battery & Charging' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Capacity',      '4685 mAh (est.)',     1),
(@s,'Video Playback','Up to 33 hours',      2),
(@s,'Wired Charging','27W (MagSafe cable)', 3),
(@s,'MagSafe',       '25W',                 4),
(@s,'Qi2',           '15W',                 5);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Design & Build' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Dimensions','163.0 x 77.6 x 8.25 mm',1),
(@s,'Weight',    '227g',                   2),
(@s,'Frame',     'Grade 5 Titanium',       3),
(@s,'Back',      'Textured matte glass',   4),
(@s,'IP Rating', 'IP68 (6m, 30min)',       5);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Connectivity' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'5G',       'Sub-6GHz, mmWave',                   1),
(@s,'Wi-Fi',    'Wi-Fi 7 (802.11be)',                  2),
(@s,'Bluetooth','5.3',                                 3),
(@s,'USB',      'USB 3 (10Gb/s) Type-C',               4),
(@s,'NFC',      'Yes',                                 5),
(@s,'Satellite','Emergency SOS + Roadside Assistance', 6);

-- ---- Xiaomi 15 Ultra ----------------------------------------
SET @pid = 'xiaomi_15ultra';
INSERT INTO spec_sections (phone_id, title, sort_order) VALUES
(@pid,'Display',1),(@pid,'Performance',2),(@pid,'Camera',3),
(@pid,'Battery & Charging',4),(@pid,'Design & Build',5),(@pid,'Connectivity',6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Display' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Screen Size',    '6.73 inches',          1),
(@s,'Technology',     'LTPO AMOLED',           2),
(@s,'Resolution',     '3200 x 1440 (QHD+)',    3),
(@s,'Refresh Rate',   '1-120Hz',              4),
(@s,'Peak Brightness','3200 nits',             5),
(@s,'Protection',     'Xiaomi Shield Glass 2', 6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Performance' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Chipset','Snapdragon 8 Elite',      1),
(@s,'CPU',    'Octa-core up to 4.32GHz',2),
(@s,'GPU',    'Adreno 830',              3),
(@s,'RAM',    '16GB / 24GB LPDDR5T',    4),
(@s,'Storage','512GB / 1TB UFS 4.0',    5),
(@s,'OS',     'Android 15, HyperOS 2',  6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Camera' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Main Camera',   '200MP f/1.63 Leica Summilux, 1-inch OIS',1),
(@s,'Ultrawide',     '50MP f/1.8 122 deg Leica',               2),
(@s,'Telephoto',     '50MP f/2.5 3.2x optical',                3),
(@s,'Periscope Tele','50MP f/4.3 4.3x optical',                4),
(@s,'Front Camera',  '32MP f/2.0',                             5),
(@s,'Video',         '8K@30fps, 4K@120fps',                    6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Battery & Charging' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Capacity',         '6000 mAh',        1),
(@s,'Wired Charging',   '90W HyperCharge', 2),
(@s,'Wireless Charging','80W',              3),
(@s,'Reverse Wireless', '10W',              4);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Design & Build' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Dimensions','161.3 x 75.3 x 9.5 mm',  1),
(@s,'Weight',    '226g',                    2),
(@s,'Back',      'Vegan leather / ceramic', 3),
(@s,'IP Rating', 'IP68',                    4);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Connectivity' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'5G',        'Yes',            1),
(@s,'Wi-Fi',     'Wi-Fi 7',        2),
(@s,'Bluetooth', '6.0',            3),
(@s,'USB',       'USB 3.2 Type-C', 4),
(@s,'NFC',       'Yes',            5),
(@s,'IR Blaster','Yes',            6);

-- ---- Pixel 9 Pro XL -----------------------------------------
SET @pid = 'google_pixel9proxl';
INSERT INTO spec_sections (phone_id, title, sort_order) VALUES
(@pid,'Display',1),(@pid,'Performance',2),(@pid,'Camera',3),
(@pid,'Battery & Charging',4),(@pid,'Design & Build',5),(@pid,'Connectivity',6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Display' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Screen Size',    '6.8 inches',            1),
(@s,'Technology',     'LTPO OLED',              2),
(@s,'Resolution',     '2992 x 1344',            3),
(@s,'Refresh Rate',   '1-120Hz',               4),
(@s,'Peak Brightness','3000 nits',              5),
(@s,'Protection',     'Gorilla Glass Victus 2', 6);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Performance' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Chipset','Google Tensor G4',             1),
(@s,'RAM',    '16GB LPDDR5',                 2),
(@s,'Storage','128GB / 256GB / 512GB / 1TB', 3),
(@s,'OS',     'Android 14',                  4);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Camera' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Main Camera',  '50MP f/1.68 Octa PD OIS',               1),
(@s,'Ultrawide',    '48MP f/1.7 autofocus',                   2),
(@s,'Telephoto',    '48MP f/2.8 5x optical zoom (Periscope)', 3),
(@s,'Front Camera', '10.5MP f/2.2',                          4),
(@s,'Video',        '4K@60fps, Best Take, Magic Eraser',      5);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Battery & Charging' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Capacity',         '5060 mAh', 1),
(@s,'Wired Charging',   '37W',      2),
(@s,'Wireless Charging','Qi2 15W',  3),
(@s,'Battery Share',    'Yes',      4);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Design & Build' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'Dimensions','162.8 x 76.6 x 8.5 mm', 1),
(@s,'Weight',    '221g',                   2),
(@s,'Frame',     'Polished Titanium',      3),
(@s,'IP Rating', 'IP68',                   4);

SET @s = (SELECT id FROM spec_sections WHERE phone_id = @pid AND title = 'Connectivity' COLLATE utf8_general_ci);
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
(@s,'5G',       'Sub-6GHz, mmWave', 1),
(@s,'Wi-Fi',    'Wi-Fi 7',          2),
(@s,'Bluetooth','5.3',              3),
(@s,'USB',      'USB 3.2 Type-C',   4),
(@s,'UWB',      'Yes',              5);

-- NOTE: Follow the same INSERT pattern above to add full specs
-- for the remaining 20 phones, or use the PHP seed script in
-- data/seed.php.

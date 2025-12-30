-- DernekWeb örnek şeması
CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    value INT NOT NULL
);

CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) DEFAULT 'fa-circle-check'
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    event_date DATE NOT NULL,
    location VARCHAR(120) NOT NULL,
    cover_image TEXT,
    summary TEXT,
    details TEXT,
    cta_label VARCHAR(120) DEFAULT 'Katılım Formu',
    cta_link VARCHAR(255) DEFAULT '#'
);

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    summary TEXT,
    content TEXT,
    cover_image TEXT,
    category VARCHAR(80) DEFAULT 'Genel',
    author VARCHAR(120) DEFAULT 'Editör',
    published_at DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    role VARCHAR(120) NOT NULL,
    quote TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL
);

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL,
    phone VARCHAR(60),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(160) NOT NULL,
    email VARCHAR(160) NOT NULL,
    phone VARCHAR(60),
    amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO stats (label, value) VALUES
('Destekçimiz', 1250),
('Gönüllü', 320),
('Aktif Proje', 24),
('Şehir', 18);

INSERT INTO programs (title, description, icon) VALUES
('Eğitim Bursları', 'Dezavantajlı öğrencilerin eğitim hayatını destekleyen burs ve mentorluk programları.', 'fa-graduation-cap'),
('Toplum Sağlığı', 'Saha çalışmaları ve atölyelerle toplum sağlığını iyileştiren projeler.', 'fa-heartbeat'),
('Afet Dayanıklılığı', 'Yerel ekiplerle iş birliği içinde afetlere hazırlık eğitimleri ve tatbikatları.', 'fa-hands-helping'),
('Gençlik ve Spor', 'Gençlerin sosyal ve fiziksel gelişimini destekleyen spor ve liderlik etkinlikleri.', 'fa-running');

INSERT INTO events (title, slug, event_date, location, cover_image, summary, details, cta_label, cta_link) VALUES
('Bölgesel Gönüllü Buluşması', 'bolgesel-gonullu-bulusmasi', '2024-08-12', 'İstanbul', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80', 'Gönüllülerimizle yılın hedeflerini paylaşacağımız ve eğitim atölyeleri düzenleyeceğimiz buluşma.', 'Gün boyu sürecek açılış konuşmaları, sahne eğitimleri ve atölyeler planlanmıştır. Kahvaltı ve öğle ikramı sağlanacaktır.', 'Kayıt Ol', 'https://forms.gle/example'),
('Kırsalda Eğitim Çalıştayı', 'kirsalda-egitim-calistayi', '2024-09-05', 'Sivas', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80', 'Yerel öğretmenlerle birlikte dijital eğitim araçlarının tanıtıldığı kapsamlı çalıştay.', 'Çalıştayda STEM odaklı müfredat örnekleri, saha deneyimleri ve gönüllü mentor eşleşmeleri paylaşılacaktır.', 'Atölyeye Katıl', 'https://forms.gle/example2'),
('Açık Hava Dayanışma Festivali', 'acik-hava-dayanisma-festivali', '2024-10-20', 'Ankara', 'https://images.unsplash.com/photo-1464375117522-1311d6a5b81f?auto=format&fit=crop&w=1200&q=80', 'Yerel üreticiler, STK’lar ve gönüllülerle dayanışmayı büyüten açık hava festivali.', 'Gün boyu konserler, sosyal girişim stantları, çocuk atölyeleri ve bağış standlarıyla dolu bir program sizi bekliyor.', 'Katılımcı Ol', 'https://forms.gle/example3');

INSERT INTO news (title, slug, summary, content, cover_image, category, author, published_at) VALUES
('Yeni Gönüllü Merkezi Açıldı', 'yeni-gonullu-merkezi-acildi', 'Ankara’daki yeni gönüllü merkezimiz kapılarını açtı; atölye ve mentorluk alanları hazır.', 'Yeni merkez, yıl boyunca 5.000 gence ulaşmayı hedefleyen programlara ev sahipliği yapacak. Açılış haftasında gönüllü eğitimleri ve hızlandırılmış mentorluk oturumları gerçekleştirilecek.', 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80', 'Duyuru', 'Editör', '2024-06-01'),
('İklim Dostu Kampanya Başladı', 'iklim-dostu-kampanya-basladi', 'Sürdürülebilir yaşam için 6 şehirde atölyeler ve okul programları başlattık.', 'Geri dönüşüm, enerji verimliliği ve sıfır atık konularında sertifikalı eğitimler verilecek. Kampanya kapsamında şehir rehberleri ve öğretmen eğitimleri ücretsiz sağlanacak.', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80', 'Kampanya', 'Editör', '2024-05-22'),
('Bursiyer Mezuniyet Töreni', 'bursiyer-mezuniyet-toreni', 'Bu yıl 120 bursiyerimizi mezuniyet töreniyle kutladık, %87 istihdam başarısı yakaladık.', 'Programı tamamlayan gençler, yeni gönüllülerle deneyimlerini paylaştı. Mezunlarımızdan 23’ü mentorluk programına destek veren gönüllüler arasına katıldı.', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80', 'Etki Hikayesi', 'Editör', '2024-04-30');

INSERT INTO testimonials (name, role, quote) VALUES
('Zeynep Karaca', 'Gönüllü', 'Her etkinlikte yeni bir hayat hikâyesine dokunuyoruz; ekiple çalışmak büyük mutluluk.'),
('Mehmet Öztürk', 'Destekçi', 'Projelerin ölçülebilir etkileri beni çok etkiliyor, bağışımın nereye gittiğini biliyorum.'),
('Elif Kaya', 'Bursiyer', 'Mentorluk programı kariyer hedefimi şekillendirdi; topluluğun desteği çok güçlü.');

INSERT INTO partners (name) VALUES
('Anadolu Kolektif'),
('Anka Teknoloji'),
('Kuzey Işıkları'),
('Deniz Finans'),
('Ege Medya');

INSERT INTO site_settings (setting_key, setting_value) VALUES
('hero_headline', 'Güçlü bir dernek sitesi ile daha çok insana ulaşın'),
('hero_subtitle', 'Tüm sayfaları yönetim panelinden düzenleyebileceğiniz modern, veritabanı destekli ve mobil uyumlu dernek altyapısı.'),
('hero_tagline', 'Dernek Yazılım · Paylaşımlı hosting hazır'),
('hero_primary_cta', 'Bağış Yap'),
('hero_primary_link', 'donate.php'),
('hero_secondary_cta', 'İletişime Geç'),
('hero_secondary_link', 'contact.php'),
('info_phone', '+90 212 000 00 00'),
('info_email', 'destek@dernekweb.com'),
('info_address', 'İstanbul, Türkiye'),
('topbar_note', 'Şeffaflık ve güven ile 18 ilde aktifiz.'),
('gallery_primary', 'https://images.unsplash.com/photo-1545239351-1141bd82e8a6?auto=format&fit=crop&w=1400&q=80'),
('gallery_secondary', 'https://images.unsplash.com/photo-1529333166433-0f3f7e2b2f77?auto=format&fit=crop&w=800&q=80'),
('gallery_tertiary', 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=800&q=80');

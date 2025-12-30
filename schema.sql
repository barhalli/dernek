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
    event_date DATE NOT NULL,
    location VARCHAR(120) NOT NULL,
    summary TEXT
);

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    summary TEXT,
    content TEXT,
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

INSERT INTO events (title, event_date, location, summary) VALUES
('Bölgesel Gönüllü Buluşması', '2024-08-12', 'İstanbul', 'Gönüllülerimizle yılın hedeflerini paylaşacağımız ve eğitim atölyeleri düzenleyeceğimiz buluşma.'),
('Kırsalda Eğitim Çalıştayı', '2024-09-05', 'Sivas', 'Yerel öğretmenlerle birlikte dijital eğitim araçlarının tanıtıldığı kapsamlı çalıştay.'),
('Açık Hava Dayanışma Festivali', '2024-10-20', 'Ankara', 'Yerel üreticiler, STK’lar ve gönüllülerle dayanışmayı büyüten açık hava festivali.');

INSERT INTO news (title, summary, content, author, published_at) VALUES
('Yeni Gönüllü Merkezi Açıldı', 'Ankara’daki yeni gönüllü merkezimiz kapılarını açtı; atölye ve mentorluk alanları hazır.', 'Yeni merkez, yıl boyunca 5.000 gence ulaşmayı hedefleyen programlara ev sahipliği yapacak.', 'Editör', '2024-06-01'),
('İklim Dostu Kampanya Başladı', 'Sürdürülebilir yaşam için 6 şehirde atölyeler ve okul programları başlattık.', 'Geri dönüşüm, enerji verimliliği ve sıfır atık konularında sertifikalı eğitimler verilecek.', 'Editör', '2024-05-22'),
('Bursiyer Mezuniyet Töreni', 'Bu yıl 120 bursiyerimizi mezuniyet töreniyle kutladık, %87 istihdam başarısı yakaladık.', 'Programı tamamlayan gençler, yeni gönüllülerle deneyimlerini paylaştı.', 'Editör', '2024-04-30');

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

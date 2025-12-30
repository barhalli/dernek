# DernekWeb

Bootstrap 5 ile tasarlanmış, paylaşımlı hosting uyumlu ve phpMyAdmin/MySQL ile çalışan dernek web sitesi şablonu. PDO ile güvenli veri erişimi, örnek SQL şeması ve hazır sayfa içerikleri içerir.

## Kurulum
1. `config/config.example.php` dosyasını `config/config.php` olarak kopyalayın ve veritabanı bilgilerinizi girin.
   - Yönetim paneli için varsayılan bilgiler `admin/changeme123` şeklindedir; yayına almadan önce `config.php` içinde güncelleyin.
2. phpMyAdmin ya da MySQL istemcisiyle `schema.sql` dosyasını içeri aktarın.
3. Dosyaları paylaşımlı hosting ortamının web köküne veya bir alt klasöre yükleyin; uygulama bulunduğu klasörü otomatik algılayıp bağlantıları buna göre üretir.
4. Tarayıcıdan sitenizi açın; veritabanı yoksa sayfa içeriği otomatik olarak örnek verilerle doldurulur.

## Sayfalar
- `index.php`: Ana sayfa, programlar, etkinlikler, haber özetleri ve referanslar.
- `about.php`: Misyon, değerler ve programların tanıtımı.
- `events.php`: Yaklaşan etkinlikler listesi.
- `news.php`: Haber ve duyuru kartları.
- `donate.php`: Bağış formu (donations tablosuna yazar) ve banka bilgileri.
- `contact.php`: İletişim formu (contact_messages tablosuna yazar).

## Teknolojiler
- [Bootstrap 5.3](https://www.jsdelivr.com/package/npm/bootstrap) ve [Font Awesome](https://www.jsdelivr.com/package/npm/@fortawesome/fontawesome-free) jsDelivr CDN üzerinden yüklenir.
- PDO ile MySQL bağlantısı; bağlantı hatalarında otomatik olarak yerel örnek veriler kullanılır.

## Özelleştirme
- `assets/css/styles.css`: Tema renkleri ve özel bileşenler.
- `assets/js/main.js`: Küçük arayüz iyileştirmeleri.
- `data/sample_data.php`: Veritabanı erişimi olmadığı durumdaki örnek içerikler.

## Testler
- Tüm PHP dosyaları için sözdizimi kontrolü: `./scripts/php_check.sh`
- Zorunlu sayfaların varlığını ve PHP sözdizimini birlikte doğrulayan denetim: `./scripts/site_audit.sh`

## Yönetim Paneli
- `/admin/login.php` adresinden (yüklediğiniz klasör altında) giriş yaparak istatistik, program, etkinlik, haber, referans ve iş ortağı kayıtlarını yönetebilirsiniz.
- İletişim ve bağış formlarından gelen kayıtlar **Form Kayıtları** sekmesinde listelenir.

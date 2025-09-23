# SınıfNizam - Sınıf Yönetim Sistemi (SYS)

SınıfNizam, paylaşımcı hosting (cPanel) ortamlarında sorunsuzca çalışacak şekilde tasarlanmış hafif bir PHP sınıf yönetim sistemidir. Öğretmenler, yöneticiler ve veliler için yoklama, not takibi, duyurular, mesajlaşma ve yedekleme gibi günlük ihtiyaçları pratik şekilde sunar.

## Başlangıç

### Minimum Gereksinimler
- PHP 8.1 veya üzeri (PDO, intl, mbstring, gd, zip eklentileri aktif)
- MySQL/MariaDB (utf8mb4)
- Apache veya Nginx (public/ klasörü web kökü olmalıdır)
- Opsiyonel: Composer (PhpSpreadsheet ve PHPMailer için)

### Kurulum Adımları
1. Proje dosyalarını sunucunuza yükleyin. `public/` klasörünü domain kökü olarak ayarlayın veya `.htaccess` yönlendirmesini kullanın.
2. Veritabanı oluşturun ve yetkili bir kullanıcı tanımlayın.
3. Tarayıcıdan `install.php` dosyasını açın ve veritabanı bilgilerinizi girin.
4. Kurulum tamamlandığında `install.lock` dosyası oluşur. Güvenlik için `install.php` dosyasını silin veya erişimi kısıtlayın.
5. Varsayılan yönetici hesabı: **admin@okul.local** / **Admin123!**

### Opsiyonel Composer Kurulumu
```
composer install
```
Bu adım PHPMailer ve PhpSpreadsheet kütüphanelerini yükler. Composer kullanmayan ortamlarda sistem CSV tabanlı içe/dışa aktarım ile çalışmaya devam eder.

## Özellikler
- **Kimlik Doğrulama:** Admin, öğretmen, veli, öğrenci rolleri. Şifre sıfırlama e-postası, oturum ve rate-limit koruması.
- **Sınıf & Öğrenci Yönetimi:** Sınıf oluşturma/düzenleme, öğrenci listeleri, CSV/XLSX içe aktarma, kayıt eşleştirme.
- **Yoklama:** Günlük yoklama ekranı, durum notları, PDF/CSV raporları.
- **Not Yönetimi:** Değerlendirme tanımlama, toplu not girişi, istatistikler, CSV dışa aktarım.
- **Duyurular & Dosyalar:** Sınıf bazlı duyuru, güvenli dosya yükleme (mime/boyut kontrolü), webroot dışı depolama.
- **Takvim:** Haftalık ders programı, yaklaşan sınav/ödev özetleri.
- **Mesajlaşma:** Öğretmen-veli/öğrenci mesajlaşması, yanıt zinciri, okundu bilgisi.
- **Raporlar:** Devamsızlık özeti, not dağılım grafikleri (Chart.js), riskli öğrenci listeleri.
- **Yedekleme:** Tek tıkla SQL dökümü veya uploads klasörü ZIP arşivi.
- **Cron Uçları:** `/cron/daily?token=...` ve `/cron/hourly?token=...` adreslerini WebCron ile tetikleyin.

## Dizın Yapısı
```
app/
  Config/        Uygulama ve veritabanı ayarları
  Controllers/   MVC kontrolcüleri
  Models/        PDO tabanlı veri katmanı
  Views/         Tailwind tabanlı arayüzler
  Services/      Mail, CSV/XLSX, PDF, depolama, cache yardımcıları
  Helpers/       Global yardımcı fonksiyonlar ve güvenlik araçları
  Storage/       uploads, cache, logs ve örnek çıktı dosyaları
public/
  index.php      Giriş noktası
  .htaccess      Pretty URL
  assets/        Hafif JS/CSS
install.php       İlk kurulum sihirbazı
composer.json     İsteğe bağlı bağımlılıklar
```

## Örnek Çıktılar
`app/Storage/examples/` klasöründe aşağıdaki örnek dosyalar yer alır:
- `attendance_sample.pdf` – Yoklama raporu örneği
- `attendance_sample.csv` – Yoklama CSV çıktısı
- `grades_sample.csv` – Not dışa aktarım örneği
- `announcement_email.html` – Duyuru e-postası taslağı

## Cron Kullanımı
- **Günlük işler:** `https://alanadiniz.com/cron/daily?token=degistir-bu-anahtari`
- **Saatlik işler:** `https://alanadiniz.com/cron/hourly?token=degistir-bu-anahtari`
Token değerini `app/Config/config.php` içerisinden özelleştirin.

## Güvenlik Notları
- Production ortamında `display_errors` kapalı tutulmalıdır.
- `install.php` dosyasını kurulumdan sonra kaldırın veya koruyun.
- `app/Storage/uploads` dizinine doğrudan web erişimi verilmemelidir.
- CSRF tokenleri her formda otomatik eklenir; form kopyalanırken kontrol edin.

## Destek
Sorularınız için proje ekibine ulaşın veya issue açın. Katkılarınızı bekleriz.

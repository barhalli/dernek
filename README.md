# Dernek Dijital

Dijital ürünlerin satışını yönetebileceğiniz landing page ve yönetim panelinden oluşan Flask tabanlı örnek proje.

## Özellikler
- Mobil uyumlu landing page ile ürün listeleme ve satın alma talebi toplama
- Yönetici girişi olan admin panel
- Müşteri profilleri, sipariş geçmişi ve notlardan oluşan basit CRM
- Sipariş durumu takibi ve satış istatistikleri
- WhatsApp ve e-posta iletişim kısayolları
- SQLite veritabanı ile kalıcı veri saklama

## Kurulum
1. Bağımlılıkları yükleyin:
   ```bash
   python -m venv .venv
   source .venv/bin/activate
   pip install -r requirements.txt
   ```
2. Ortam değişkenlerini isteğe göre `.env` dosyası oluşturarak tanımlayın:
   ```env
   SECRET_KEY=guclu-bir-anahtar
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD=admin123
   DATABASE_URL=sqlite:///dernek.db
   ```
3. Uygulamayı başlatın:
   ```bash
   flask --app app run
   ```

İlk açılışta örnek ürünler ve yönetici hesabı otomatik olarak oluşturulur. Admin paneline `http://localhost:5000/admin/login` adresinden erişebilirsiniz.

## Notlar
- Ürünler, müşteriler ve siparişler SQLite veritabanında saklanır.
- Yönetici şifresi varsayılan olarak `.env` içindeki `ADMIN_PASSWORD` değerinden alınır ve veritabanında hashlenmiş olarak tutulur.
- Üretim ortamı için güçlü bir `SECRET_KEY` belirleyip HTTPS üzerinden yayınlamanız önerilir.

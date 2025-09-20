# Dernek Hesap Makinesi

Basit ama esnek bir komut satırı hesap makinesi. Türkçe ve İngilizce işlem adlarını
kullanarak toplama, çıkarma, çarpma, bölme, üs alma ve mod alma işlemlerini
yapabilirsiniz.

## Kurulum

Projeyi klonladıktan sonra tercihen sanal ortam kurup bağımlılıkları yükleyin:

```bash
python -m venv .venv
source .venv/bin/activate
pip install -r requirements-dev.txt  # yalnızca testler için gerekliyse
```

Projede özel bir bağımlılık kullanılmadığından yalnızca Python yeterlidir. Testleri
çalıştırmak için `pytest`'e ihtiyacınız vardır.

## Kullanım

İşlem yapmak için `python -m calculator <işlem> <sayı1> <sayı2> ...` komutunu
kullanabilirsiniz. Örnekler:

```bash
python -m calculator topla 1 2 3
python -m calculator çıkar 10 3 1
python -m calculator carp 2 3 4
python -m calculator bol 20 2 5
python -m calculator us 2 3
python -m calculator mod 10 3
```

İşlem adlarını görmek için `listele` komutunu kullanın:

```bash
python -m calculator listele
```

Toplama, çıkarma, çarpma ve bölme işlemleri en az iki sayı ister. Üs ve mod
işlemleriyse tam olarak iki sayı gerektirir.

Hem Türkçe (`topla`, `çıkar`, `çarp`, `böl`, `üs`, `mod`) hem de İngilizce (`add`,
`subtract`, `multiply`, `divide`, `power`, `modulo`) işlem adları desteklenir.

## Testler

`pytest` ile otomatik testleri çalıştırabilirsiniz:

```bash
pytest
```

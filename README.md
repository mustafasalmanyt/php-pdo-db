# PHP Database Kütüphanesi

Modern ve güvenli PHP/MySQL veritabanı işlemleri için geliştirilmiş hafif ve kullanışlı bir kütüphane.

## ✨ Özellikler

- **PDO tabanlı**: Güvenli ve modern veritabanı erişimi
- **Prepared Statements**: SQL injection saldırılarına karşı koruma
- **Environment Variables**: Güvenli yapılandırma yönetimi
- **Exception Handling**: Kapsamlı hata yönetimi ve loglama
- **Maintenance Tools**: Veritabanı bakım araçları
- **Türkçe Dil Desteği**: Yerel karakter seti desteği
- **Kolay Kullanım**: Basit ve anlaşılır API

## 🚀 Kurulum

1. Kütüphaneyi projenize dahil edin:
```php
require_once 'database.class.php';
```

2. **Log sistemini dahil edin** (Zorunlu):
```php
require_once 'log.class.php'; // GitHub profilimde bulabilirsiniz
```

4. Kütüphaneyi kullanmaya başlayın:
```env
DB_HOSTNAME=localhost
DB_NAME=veritabani_adi
DB_USERNAME=kullanici_adi
DB_PASSWORD=sifre
DB_CHARSET=utf8
DB_COLLATION=utf8_turkish_ci
```

3. Kütüphaneyi kullanmaya başlayın:
```php
<?php
define("index", true); // Güvenlik kontrolü
$db = new database();
?>
```

## 📖 Kullanım

### Temel Sorgular

#### Çoklu Satır Verilerini Çekme
```php
$users = $db->getRows("SELECT * FROM users WHERE status = ?", [1]);
foreach($users as $user) {
    echo $user->name;
}
```

#### Tek Satır Veri Çekme
```php
$user = $db->getRow("SELECT * FROM users WHERE id = ?", [$userId]);
echo $user->name;
```

#### Tek Sütun Değeri Alma
```php
$userCount = $db->getColumn("SELECT COUNT(*) FROM users");
echo "Toplam kullanıcı: " . $userCount;
```

#### Satır Sayısını Öğrenme
```php
$count = $db->getRowsCount("SELECT * FROM users WHERE active = ?", [1]);
echo "Aktif kullanıcı sayısı: " . $count;
```

### Veri İşlemleri

#### Yeni Kayıt Ekleme
```php
$lastId = $db->Insert(
    "INSERT INTO users (name, email, created_at) VALUES (?, ?, ?)",
    [$name, $email, date('Y-m-d H:i:s')]
);
echo "Yeni kullanıcı ID: " . $lastId;
```

#### Kayıt Güncelleme
```php
$affectedRows = $db->Update(
    "UPDATE users SET name = ?, email = ? WHERE id = ?",
    [$newName, $newEmail, $userId]
);
echo $affectedRows . " kayıt güncellendi";
```

#### Kayıt Silme
```php
$deletedRows = $db->Delete(
    "DELETE FROM users WHERE id = ?",
    [$userId]
);
echo $deletedRows . " kayıt silindi";
```

### Gelişmiş İşlemler

#### Veritabanı Oluşturma
```php
$db->CreateDB("CREATE DATABASE yeni_veritabani");
```

#### Tablo İşlemleri
```php
$createTable = "CREATE TABLE test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->TableOperations($createTable);
```

#### Veritabanı Bakımı
```php
$db->Maintenance(); // Tüm tabloları kontrol eder, analiz eder ve optimize eder
```

## 🔧 API Referansı

### Veri Çekme Metodları

| Method | Açıklama | Dönüş Değeri |
|--------|----------|--------------|
| `getRows($query, $params)` | Çoklu satır verisi çeker | Array of Objects |
| `getRow($query, $params)` | Tek satır verisi çeker | Object |
| `getColumn($query, $params)` | Tek sütun değeri çeker | Mixed |
| `getRowsCount($query, $params)` | Satır sayısını döndürür | Integer |

### Veri İşleme Metodları

| Method | Açıklama | Dönüş Değeri |
|--------|----------|--------------|
| `Insert($query, $params)` | Yeni kayıt ekler | Last Insert ID |
| `Update($query, $params)` | Kayıt günceller | Affected Rows |
| `Delete($query, $params)` | Kayıt siler | Affected Rows |

### Yardımcı Metodları

| Method | Açıklama |
|--------|----------|
| `CreateDB($query)` | Yeni veritabanı oluşturur |
| `TableOperations($query)` | Tablo işlemleri (CREATE, ALTER, DROP) |
| `Maintenance()` | Tüm tabloların bakımını yapar |

## 🛡️ Güvenlik

- **Prepared Statements**: Tüm sorgular prepared statement kullanır
- **Parameter Binding**: Otomatik parametre bağlama
- **Exception Handling**: Güvenli hata yönetimi
- **Access Control**: `index` sabiti ile erişim kontrolü

## ⚠️ Gereksinimler

- PHP 7.0 veya üzeri
- PDO MySQL extension
- **Log sistemi**: Hata loglaması için `log.class.php` dosyasını da projenize dahil etmelisiniz (GitHub profilimde bulabilirsiniz)

## 🐛 Hata Yönetimi

Kütüphane tüm veritabanı hatalarını yakalar ve log dosyasına kaydeder:

```php
// Hata durumunda otomatik olarak log'a yazılır
// Ve kullanıcıya güvenli hata mesajı gösterilir
```

## 📝 Lisans

Bu proje MIT lisansı altında yayınlanmıştır.

## 👨‍💻 Geliştirici

**Mustafa Salman YT**
- Website: [mustafa.slmn.tr](https://mustafa.slmn.tr)
- Email: mustafa@slmn.tr


## 🙏 Teşekkürler

PHP topluluğuna ve açık kaynak geliştiricilere teşekkürler.

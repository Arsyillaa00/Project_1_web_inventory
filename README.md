### v.1.000.004
-----

fitur yang ditambah:
- sidebar
- check tabel status dan products
- create data demo untuk tabel status dan products
- menampilkan total data user, status, dan products (tanggal terakhir update)

##### CHECK TABLE
fungsi untuk check table sudah ada atau belum
- $db adalah nama database
```php
require_once "app/controller.php";
check_tabel_user($db);
check_tabel_status($db);
check_tabel_products($db)
```
hasil result jika tabel user/status/products sudah ada = 1. Namun apabila tabel user/status/products belum ada, maka fungsi akan otomatis create tabel user/status/products dan membuat akun demo (jika berhasil nilainya 1, apabila gagal nilainya 0)

##### CHECK TOTAL DATA TERSIMPAN PADA TABEL
fungsi untuk check total data yang tersimpan di dalam tabel user/status/products.
untuk fungsi products, menampilkan total dan tanggal terakhir update.
- $db adalah nama database
```php
require_once "app/controller.php";
check_count_user($db);
check_count_status($db);
check_count_products($db)
```
hasil result menampilkan jumlah data yang ada di dalam tabel user/status/products. Sedangkan untuk hasil result fungsi product menampilkan jumlah data dan tanggal terakhir update.


### v.1.000.003
-----

fitur yang ditambah:
- style bootstrap 5.3
- layout intro, home, dan login

##### CARA PEMANGGILAN LAYOUT
fungsi untuk memanggil layout
```php
require_once "app/router.php";
```
lokasi layout berada di folder template

```php
include "template/{nama_file}.php";
```

### v.1.000.002
-----

fitur yang ditambah:
- koneksi database
- create tabel user
- login
- logout

##### KONEKSI MYSQL
fungsi untuk check connect ke mysqli atau tidak
```php
require_once "app/controller.php";
connection();
```
hasil result koneksi mysql

##### CHECK DATABASE
fungsi untuk check database sudah ada atau belum
- $mysql adalah nama koneksi sql
- $db adalah nama database
```php
require_once "app/controller.php";
check_database($mysql, $db);
```
hasil result total database ada 1 atau 0

##### CREATE DATABASE
fungsi untuk membuat database, jika belum ada databasenya
- $mysql adalah nama koneksi sql
- $db adalah nama database
```php
require_once "app/controller.php";
create_database($mysql, $db);
```
hasil result jika berhasil outputnya 1, apabila gagal maka outputnya 0

##### KONEKSI DATABASE
fungsi untuk check connect mysql ke database
```php
require_once "app/controller.php";
mysql();
```
hasil result koneksi mysql ke database

##### CHECK TABEL USER
fungsi untuk check tabel user sudah ada isinya atau belum
- $mysql adalah nama koneksi sql ke database
```php
require_once "app/controller.php";
check_tabel_user($mysql)
```
hasil result jika tabel user sudah ada = 1. Namun apabila tabel user belum ada, maka fungsi akan otomatis create tabel user dan membuat akun demo (jika berhasil nilainya 1, apabila gagal nilainya 0)

##### MEMBUAT LOGIN
fungsi untuk melakukan login dashboard
- $mysql adalah nama koneksi sql ke database
- $email adalah nama attribut untuk email
- $password adalah nama attribut untuk password
```php
require_once "../app/controller.php";
login($mysql, $email, $password)
```
hasil result jika berhasil login, maka data user akan menjadi session. Namun apabila gagal, maka form login akan di tampilkan lagi

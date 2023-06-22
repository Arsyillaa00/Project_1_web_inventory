### v.1.000.002
-----

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


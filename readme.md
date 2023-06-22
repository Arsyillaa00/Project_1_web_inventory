### v.1.000.002
-----

##### koneksi mysql
fungsi untuk check connect ke mysqli atau tidak
```php
require_once "app/controller.php";
connection();
```
hasil result koneksi mysql

##### check database
fungsi untuk check database sudah ada atau belum
- $mysql adalah nama koneksi sql
- $db adalah nama database
```php
require_once "app/controller.php";
check_database($mysql, $db);
```
hasil result total database ada 1 atau 0

##### create database
fungsi untuk membuat database, jika belum ada databasenya
- $mysql adalah nama koneksi sql
- $db adalah nama database
```php
require_once "app/controller.php";
create_database($mysql, $db);
```
hasil result jika berhasil outputnya 1, apabila gagal maka outputnya 0


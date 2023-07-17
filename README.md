### v.1.000.010
-----

fitur yang ditambah:
- menampilkan detail products, user, dan status
- menampilkan products aktif pada page user

##### MENAMPILKAN DETAIL PRODUCTS, USER DAN STATUS
fungsi untuk mengambil data products di MYSQL, kemudian akan ditampilkan di file products.php
- $db adalah nama database
- $id adalah nama untuk id_user yang berfungsi untuk mencari id dari data yang akan ditampilkan
```php
require_once "app/controller.php";
detail_user($db,$id);
detail_status($db,$id);
detail_products($db,$id);
```
hasil result menampilkan detail data dari tabel products, user, dan status.

##### MENAMPILKAN DATA PRODUCTS BERSTATUS AKTIF PADA PAGE USER
fungsi untuk mengambil data products di MYSQL, kemudian akan ditampilkan di file index.php pada folder user
- $db adalah nama database
```php
require_once "app/controller.php";
check_count_products_aktif($db);
```
hasil result menampilkan data nama, harga, total, dan tanggal update dari tabel products, namun data yang ditampilkan pada setiap page hanya memiliki limit 4 baris data. Data berupa array.


### v.1.000.009
-----

fitur yang ditambah:
- menampilkan data dari tabel products
- edit data products
- tambah data products

##### MENGAMBIL DATA PRODUCTS DARI DATABASE
fungsi untuk mengambil data products di MYSQL, kemudian akan ditampilkan di file products.php
- $db adalah nama database
- $page adalah nama halaman pada tabel
```php
require_once "app/controller.php";
tabel_products($db, $page);
```
hasil result menampilkan data nama, harga, total, status, tanggal dibuat dan tanggal update dari tabel products, namun data yang ditampilkan pada setiap page hanya memiliki limit 4 baris data. Data berupa array.

##### EDIT DATA PRODUCTS
fungsi untuk mengedit data status
- $db adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
update_products($db,$post);
```
hasil result data yang diubah nama, harga, total, dan status.

##### MENAMBAHKAN DATA PRODUCTS
fungsi untuk menambahkan data status ke database
- $mysql adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
insert_products($db,$post);
```
hasil result menambahkan data products ke dalam database. jika data nama, harga, total, dan status sudah dipakai, maka akan muncul notifikasi gagal diinput.

### v.1.000.008
-----

fitur yang ditambah:
- tabel status
- edit data status
- tambah data status

##### MENGAMBIL DATA STATUS DARI DATABASE
fungsi untuk mengambil data status di MYSQL, kemudian akan ditampilkan di file status.php
- $db adalah nama database
- $page adalah nama halaman pada tabel
```php
require_once "app/controller.php";
tabel_status($db, $page);
```
hasil result menampilkan data title dan level dari tabel status, namun data yang ditampilkan pada setiap page hanya memiliki limit 4 baris data. Data berupa array.

##### EDIT DATA STATUS
fungsi untuk mengedit data status
- $db adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
update_status($db,$post);
```
hasil result data yang diubah title dan level.

##### MENAMBAHKAN DATA STATUS
fungsi untuk menambahkan data status ke database
- $mysql adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
insert_status($db,$post);
```
hasil result menambahkan data status ke dalam database. jika data title dan level sudah dipakai, maka akan muncul notifikasi gagal diinput.

### v.1.000.007
-----

fitur yang ditambah:
- edit data user
- profil (detail profil user)

##### EDIT DATA USER
fungsi untuk mengedit data user
- $db adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
update_user($db,$post);
```
hasil result data yang diubah nama, email, status. jika id user sama dengan session yang digunakan secara otomatis memperbarui session.

##### PROFIL (DETAIL PROFIL USER)
fungsi untuk menampilkan fitur profil
- $db adalah nama database
- $id adalah nama untuk id_user yang berfungsi untuk mencari id dari data yang akan ditampilkan
```php
require_once "app/controller.php";
detail_user($db,$id);
```
hasil result berupa array.

### v.1.000.006
-----

fitur yang ditambah:
- menambahkan data user
- hapus data user

##### MENAMBAHKAN DATA USER
fungsi untuk menambahkan data user ke database
- $db adalah nama database
- $post adalah nama untuk data yang diinputkan
```php
require_once "app/controller.php";
insert_user($db,$post);
```
hasil result menambahkan data ke dalam database. jika data nama,email,password sudah dipakai, maka akan muncul notifikasi gagal diinput.

##### MENGHAPUS DATA USER
fungsi untuk menghapus data user ke database
- $db adalah nama database
- $id adalah nama untuk mencari id dari data yang akan dihapus
```php
require_once "app/controller.php";
delete_user($db,$id);
```
hasil result menghapus data yang ada di database, dan data yang dihapus sesuai dengan request dari user. Apabila data yang dihapus adalah data yang digunakan untuk login, maka tombol hapus untuk data tersebut tidak akan berfungsi.

### v.1.000.005
-----

fitur yang ditambah:
- menampilkan data dari tabel user
- mengatur jumlah data yang ditampilkan di setiap page
- membuat tombol next & prev

##### MENGAMBIL DATA USER DARI DATABASE
fungsi untuk mengambil data user di MYSQL, kemudian akan ditampilkan di file user.php
- $db adalah nama database
- $page adalah nama halaman pada tabel
```php
require_once "app/controller.php";
tabel_user($db, $page);
```
hasil result menampilkan data nama dan email dari tabel user, namun data yang ditampilkan pada setiap page hanya memiliki limit 4 baris data. Data berupa array.

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
check_tabel_products($db);
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
check_count_products($db);
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
check_tabel_user($mysql);
```
hasil result jika tabel user sudah ada = 1. Namun apabila tabel user belum ada, maka fungsi akan otomatis create tabel user dan membuat akun demo (jika berhasil nilainya 1, apabila gagal nilainya 0)

##### MEMBUAT LOGIN
fungsi untuk melakukan login dashboard
- $mysql adalah nama koneksi sql ke database
- $email adalah nama attribut untuk email
- $password adalah nama attribut untuk password
```php
require_once "../app/controller.php";
login($mysql, $email, $password);
```
hasil result jika berhasil login, maka data user akan menjadi session. Namun apabila gagal, maka form login akan di tampilkan lagi

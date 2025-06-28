


# PRAKTIKUM 1
## Instal Codeigniter 4
Perintah yang dapat dijalankan untuk memanggil CLI Codeigniter adalah **php sprak**
![image](https://github.com/user-attachments/assets/48ff4e2c-9574-498a-a570-977013f95aca)

Untuk mengetahui route yang ditambahkan sudah benar, buka CLI dan jalankan perintah
berikut **php spark routes**
![image](https://github.com/user-attachments/assets/4e999a1a-cbf1-4cb9-b975-94b529bbca78)

Jika ingin menjalankan localhost maka harus melakukan perintah **php spark serve** pada CMD.

Setelah itu masuk ke tampilan web nya pada alamat **http://localhost:8080/about**
![Screenshot 2025-06-25 115753](https://github.com/user-attachments/assets/75e9c9e4-4c76-4570-98d5-5a694815ebcb)

# PRAKTIKUM 2
1. Membuat Database
   ``CREATE DATABASE lab_ci4;``
2. Membuat Tabel
```
CREATE TABLE artikel (
  id INT(11) auto_increment,
  judul VARCHAR(200) NOT NULL,
  isi TEXT,
  gambar VARCHAR(200),
  status TINYINT(1) DEFAULT 0,
  slug VARCHAR(200),
  PRIMARY KEY(id)
);
```
3. 

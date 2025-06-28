


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
3. Membuat Model direktori **app/Models** dengan nama **ArtikelModel.php**
   ```
   <?php
   namespace App\Models;
   use CodeIgniter\Model;
   class ArtikelModel extends Model
   {
      protected $table = 'artikel';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $allowedFields = ['judul', 'isi', 'status', 'slug',
      'gambar'];
   }
   ```
4. Membuat Controller dengan nama **Artikel.php** pada direktori **app/Controllers**
   ```
   <?php
   namespace App\Controllers;
   use App\Models\ArtikelModel;
   class Artikel extends BaseController
   {
      public function index()
      {
      $title = 'Daftar Artikel';
      $model = new ArtikelModel();
      $artikel = $model->findAll();
      return view('artikel/index', compact('artikel', 'title'));
      }
   }
   ```
5. Membuat View
   Buat direktori baru dengan nama **artikel** pada direktori **app/views**, kemudian buat file baru dengan nama **index.php**
   ```
   <?= $this->include('template/header'); ?>
   <?php if($artikel): foreach($artikel as $row): ?>
   <article class="entry">
   <h2<a href="<?= base_url('/artikel/' . $row['slug']);?>"><?=
   $row['judul']; ?></a>
   </h2>
   <img src="<?= base_url('/gambar/' . $row['gambar']);?>" alt="<?=
   $row['judul']; ?>">
   <p><?= substr($row['isi'], 0, 200); ?></p>
   </article>
   <hr class="divider" />
   <?php endforeach; else: ?>
   <article class="entry">
   <h2>Belum ada data.</h2>
   </article>
   <?php endif; ?>
   <?= $this->include('template/footer'); ?>
   ```
**Tambahkan beberapa data bada database**
```
INSERT INTO artikel (judul, isi, slug) VALUE
('Perkembangan Teknologi Elektronik dan Dampaknya terhadap Kehidupan Modern', 'Perkembangan Teknologi Elektronik dan Dampaknya terhadap Kehidupan Modern
Perangkat elektronik telah menjadi bagian tak terpisahkan dari kehidupan sehari-hari manusia modern. Artikel ini mengeksplorasi perkembangan teknologi elektronik dari masa ke masa dan bagaimana inovasi', 'artikel-pertamaPerkembangan Teknologi Elektronik dan Dampaknya terhadap Kehidupan Modern'),
('Olahraga Sebagai Gaya Hidup Sehat dan Sarana Pemersatu Bangsa', 'Olahraga Sebagai Gaya Hidup Sehat dan Sarana Pemersatu Bangsa
Olahraga tidak hanya bermanfaat bagi kesehatan fisik dan mental, tetapi juga memiliki nilai sosial yang tinggi sebagai alat pemersatu masyarakat. Artikel ini mengulas pentingnya olahraga sebagai bagian', 'Olahraga Sebagai Gaya Hidup Sehat dan Sarana Pemersatu Bangsa');
```
**Selanjutnya buka browser kembali, dengan mengakses url ``http://localhost:8080/artikel``**

![Screenshot 2025-06-27 131648](https://github.com/user-attachments/assets/6832c2e1-98a5-4a25-a75c-cd3ee6cf3ee6)


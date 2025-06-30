


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

6. Membuat Tampilan Detail Artikel, tambahkan fungsi baru pada **Controller Artikel** dengan nama **view()**.
   ```
   public function view($slug)
   {
      $model = new ArtikelModel();
      $artikel = $model->where([
      'slug' => $slug
      ])->first();
      // Menampilkan error apabila data tidak ada.
      if (!$artikel)
      {
      throw PageNotFoundException::forPageNotFound();
      }
      $title = $artikel['judul'];
      return view('artikel/detail', compact('artikel', 'title'));
   }
   ```
7. Membuat View Detail
   Buat view baru dengan nama **app/views/artikel/detail.php**.
   ```
   <?= $this->include('template/header'); ?>
   <article class="entry">
   <h2><?= $artikel['judul']; ?></h2>
   <img src="<?= base_url('/gambar/' . $artikel['gambar']);?>" alt="<?=
   $artikel['judul']; ?>">
   <p><?= $row['isi']; ?></p>
   </article>
   <?= $this->include('template/footer'); ?>
   ```
   **Membuat Routing untuk artikel detail** (buka kembali file **app/config/Routes.php**, kemudian tambahkan routing untuk artikel detail.
   ```$routes->get('/artikel/(:any)', 'Artikel::view/$1');```
8. Membuat Menu Admin
   Menu ini untuk proses CRUD data artikel. Buat method baru pada **Controller Artikel** dengan nama **admin_index()**.
   ```
   <?= $this->include('template/admin_header'); ?>

   <h2><?= $title; ?></h2>
   
   <!-- Form Filter & Pencarian -->
   <div class="row mb-3">
       <div class="col-md-6">
           <form id="search-form" class="form-inline">
               <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul artikel" class="form-control mr-2">
               <select name="kategori_id" id="category-filter" class="form-control mr-2">
                   <option value="">Semua Kategori</option>
                   <?php foreach ($kategori as $k): ?>
                       <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                           <?= $k['nama_kategori']; ?>
                       </option>
                   <?php endforeach; ?>
               </select>
               <input type="submit" value="Cari" class="btn btn-primary">
           </form>
       </div>
   </div>
   
   <!-- Container AJAX -->
   <div id="article-container"></div>
   <div id="pagination-container"></div>
   
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function () {
       const fetchData = (url) => {
           $.ajax({
               url: url,
               type: 'GET',
               dataType: 'json',
               headers: { 'X-Requested-With': 'XMLHttpRequest' },
               success: function (data) {
                   renderArticles(data.artikel);
                   renderPagination(data.pager, data.q, data.kategori_id);
               }
           });
       };
   
       const renderArticles = (articles) => {
           let html = '<table class="table"><thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';
           if (articles.length > 0) {
               articles.forEach(article => {
                   html += `
                       <tr>
                           <td>${article.id}</td>
                           <td><b>${article.judul}</b><br><small>${article.isi.substring(0, 50)}...</small></td>
                           <td>${article.nama_kategori}</td>
                           <td>${article.status ?? '-'}</td>
                           <td>
                               <a href="/admin/artikel/edit/${article.id}" class="btn btn-info btn-sm">Ubah</a>
                               <a href="/admin/artikel/delete/${article.id}" onclick="return confirm('Yakin menghapus data?');" class="btn btn-danger btn-sm">Hapus</a>
                           </td>
                       </tr>
                   `;
               });
           } else {
               html += '<tr><td colspan="5">Tidak ada data.</td></tr>';
           }
           html += '</tbody></table>';
           $('#article-container').html(html);
       };
   
       const renderPagination = (pager, q, kategori_id) => {
           let html = '<nav><ul class="pagination">';
           pager.links.forEach(link => {
               let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
               html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}">${link.title}</a></li>`;
           });
           html += '</ul></nav>';
           $('#pagination-container').html(html);
       };
   
       $('#search-form').on('submit', function (e) {
           e.preventDefault();
           const q = $('#search-box').val();
           const kategori_id = $('#category-filter').val();
           fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}`);
       });
   
       $('#category-filter').on('change', function () {
           $('#search-form').trigger('submit');
       });
   
       // Load pertama
       fetchData('/admin/artikel');
   });
   </script>
   
   <?= $this->include('template/admin_footer'); ?>
   ```
**Tambahkan Routing untuk menu admin sperti berikut:**
```
$routes->group('admin', function($routes) {
   $routes->get('artikel', 'Artikel::admin_index');
   $routes->add('artikel/add', 'Artikel::add');
   $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
   $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```
Akses menu admin dengan url ``http://localhost:8080/admin/artikel``
![image](https://github.com/user-attachments/assets/12495a0d-b352-4c5f-9522-1cfe2dc8748f)


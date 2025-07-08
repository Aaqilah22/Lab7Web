

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
![image](https://github.com/user-attachments/assets/86baa0fe-6081-4fcc-8c3d-1a8c1f5f573b)

9. Menambah Data Artikel
   ```
   public function add()
   {
   // validasi data.
   $validation = \Config\Services::validation();
   $validation->setRules(['judul' => 'required']);
   $isDataValid = $validation->withRequest($this->request)->run();
   if ($isDataValid)
   {
   $artikel = new ArtikelModel();
   $artikel->insert([
   'judul' => $this->request->getPost('judul'),
   'isi' => $this->request->getPost('isi'),
   'slug' => url_title($this->request->getPost('judul')),
   ]);
   return redirect('admin/artikel');
   }
   $title = "Tambah Artikel";
   return view('artikel/form_add', compact('title'));
   }
   ```

   Kemudian buat view untuk from tambah dengan nama **from_add.php**
   ```
   <?= $this->include('template/admin_header'); ?>
   <h2><?= $title; ?></h2>
   <form action="" method="post">
   <p>
   <input type="text" name="judul">
   </p>
   <p>
   <textarea name="isi" cols="50" rows="10"></textarea>
   </p>
   <p><input type="submit" value="Kirim" class="btn btn-large"></p>
   </form>
   <?= $this->include('template/admin_footer'); ?>
   ```

   Tambahkan fungsi/method baru pada controller Artikel dengan nama **edit()**
   ```
   public function edit($id)
   {
   $artikel = new ArtikelModel();
   // validasi data.
   $validation = \Config\Services::validation();
   $validation->setRules(['judul' => 'required']);
   $isDataValid = $validation->withRequest($this->request)->run();
   if ($isDataValid)
   {
   $artikel->update($id, [
   'judul' => $this->request->getPost('judul'),
   'isi' => $this->request->getPost('isi'),
   ]);
   return redirect('admin/artikel');
   }
   // ambil data lama
   $data = $artikel->where('id', $id)->first();
   $title = "Edit Artikel";
   return view('artikel/form_edit', compact('title', 'data'));
   }
   ```

   Kemudian buat view untuk from tambah dengan nama **from_edit.php**
   ```
   <?= $this->include('template/admin_header'); ?>
   <h2><?= $title; ?></h2>
   <form action="" method="post">
   <p>
   <input type="text" name="judul" value="<?= $data['judul'];?>" >
   </p>
   <p>
   <textarea name="isi" cols="50" rows="10"><?=
   $data['isi'];?></textarea>
   </p>
   <p><input type="submit" value="Kirim" class="btn btn-large"></p>
   </form>
   <?= $this->include('template/admin_footer'); ?>
   ```
   
   ``http://localhost:8080/admin/artikel/add``
   ![Screenshot 2025-04-19 192544](https://github.com/user-attachments/assets/2308d606-50ee-44cb-9930-e1975bc31de0)

10. Mengubah Data
    Tambahkan fungsi/method baru pada Controller Artikel dengan nama **delete()**
    ```
    public function delete($id)
    {
      $artikel = new ArtikelModel();
      $artikel->delete($id);
      return redirect('admin/artikel');
    }
    ```

# PRAKTIKUM 3
1. Membuat Layout Utama
   Buat folder **layout** di dalam **app/Views/**
   Buat file **main.php** di dalam folder **layout** dengan kode berikut:
   ```
   <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title><?= $title ?? 'My Website' ?></title>
       <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
   </head>
   <body>
       <div id="container">
           <header>
               <h1>Layout Sederhana</h1>
           </header>
           
           <nav>
               <a href="<?= base_url('/'); ?>" class="active">Home</a>
               <a href="<?= base_url('/artikel'); ?>">Artikel</a>
               <a href="<?= base_url('/about'); ?>">About</a>
               <a href="<?= base_url('/contact');?>">Kontak</a>
   
           </nav>
           
           <section id="wrapper">
               <section id="main">
                   <?= $this->renderSection('content') ?>
               </section>
               
               <aside id="sidebar">
                   <?= view_cell('App\Cells\ArtikelTerkini::render') ?>
                   
                   <div class="widget-box">
                       <h3 class="title">Widget Header</h3>
                       <ul>
                           <li><a href="#">Widget Link</a></li>
                           <li><a href="#">Widget Link</a></li>
                       </ul>
                   </div>
                   
                   <div class="widget-box">
                       <h3 class="title">Widget Text</h3>
                       <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu. 
                       Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer pharetra est nunc, 
                       nec pretium nunc pretium ac.</p>
                   </div>
               </aside>
           </section>
           
           <footer>
               <p>&copy; 2025 - Universitas Pelita Bangsa</p>
           </footer>
       </div>
   </body>
   </html>
   ```

2. Modifikasi File View
   Ubah **app/Views/home.php** agar sesuai dengan layout baru:
   ```
   <?= $this->extend('layout/main') ?>
   <?= $this->section('content') ?>
   <h1><?= $title; ?></h1>
   <hr>
   <p><?= $content; ?></p>
   <?= $this->endSection() ?>
   ```

3. Menampilkan Data Dinamis dengan View Cell
   - Membuat Class View Call
     Buat folder Cells di dalam app/
     Buat file ArtikelTerkini.php di dalam app/Cells/ dengan kode berikut:
     ```
     <?php
      namespace App\Cells;
      use CodeIgniter\View\Cell;
      use App\Models\ArtikelModel;
      class ArtikelTerkini extends Cell
      {
      public function render()
      {
      $model = new ArtikelModel();
      $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
      return view('components/artikel_terkini', ['artikel' => $artikel]);
      }
     ```
   - Membuat View untuk View Cell
     Buat folder components di dalam app/Views/
     Buat file artikel_terkini.php di dalam app/Views/components/ dengan kode berikut:
     ```
     <h3>Artikel Terkini</h3>
      <ul>
      <?php foreach ($artikel as $row): ?>
      <li><a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?=
      $row['judul'] ?></a></li>
      <?php endforeach; ?>
      </ul>
     ```
  
# PRAKTIKUM 4

      }

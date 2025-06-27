<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control" required>
    </p>

    <p>
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" cols="50" rows="10" class="form-control"></textarea>
    </p>

    <p>
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <!-- input gambar -->
     <p>
        <label for="gambar">Upload Gambar</label>
        <input type="file" name="gambar" id="gambar" class="form-control" required>
     </p>
    
    <p>
        <input type="submit" value="Kirim" class="btn btn-primary">
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>

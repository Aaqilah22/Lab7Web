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

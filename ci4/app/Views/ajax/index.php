<?= $this->include('template/header'); ?>

<h1>Data Artikel</h1>
<table id="artikelTable" class="table-data">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
<script>
$(document).ready(function() {
    // function to display a loading message while data is fetched
    function showLoadingMessage() {
        $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
    }

    // Buat fungsi load data 
    function loadData() {
        showLoadingMessage(); // Display loading message intially
        // Lakukan request AJAX ke URL getData
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                // Tampilkan data yang diterima server
                var tableBody = "";
                for (var i = 0; i < data.length; i++) {
                    var row = data[i];
                    tableBody += '<tr>';
                    tableBody += '<td>' + row.id + '</td>';
                    tableBody += '<td>' + row.judul + '</td>';
                    // Add a placeholder for the "Status" column (modifty as needed)
                            tableBody += '<td><span class="status">---</span></td>';
                    tableBody += '<td>';
                    //Replace with you desired actions (e.g, edit, delete)
                    tableBody += '<a href="<?= base_url('artikel/edit/')?>' + row.id + '"class="btn btn-primary">Edit</a>';
                    tableBody += '<a href="#" class="btn btn-denger btn-delete" data-id="' + row.id + '">Delete</a>';
                    tableBody += '</td>';
                    tableBody += '</tr>';
                }
                $('#artikelTable tbody').html(tableBody);
            }
        });
    }

    loadData;

    // Implement actions for buttons (e.g., delete confirmation)
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        // Add confirmation dialog or handle delection logic header

        // hapus data;
        if (confirm('Apakah Anda yakin ingin menghapus artike ini?'))
{
            $.ajax({
                url: "<?= base_url('artikel/delete/') ?>" + id,
                method: "DELETE",
                success: function(data) {
                    loadData(); //Roload Datatables to reflect changes
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    elert('Error deleting article: ' + textStatus + errorThrown);
                }
            });
        }
        console.log('Delete button clicked for ID:', id);
    });
});
</script>

<?= $this->include('template/footer'); ?>

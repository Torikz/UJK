<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pasien</h5>
        <div>
            <button class="btn btn-success btn-sm" onclick="importData()">Import Dummy</button>
            <button class="btn btn-primary btn-sm" onclick="modalTambah()">+ Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table id="tablePasien" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="modalTemplate" style="display:none;">
    <div class="modal-header">
        <h5 class="modal-title">Form Pasien</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <form id="formPasien">
            <input type="hidden" name="id" id="inputId">
            <div class="mb-3">
                <label>Nama Pasien <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama" id="inputNama" required>
            </div>
            <div class="mb-3">
                <label>No Rekam Medis <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="norm" id="inputNorm" required>
            </div>
            <div class="mb-3">
                <label>Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" name="alamat" id="inputAlamat" required></textarea>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="simpanData()">Simpan</button>
    </div>
</div>

<script>
    var table;
    $(document).ready(function() {
        table = $('#tablePasien').DataTable({
            ajax: "<?= base_url('pasien/read') ?>",
            columns: [
                { data: 'id' },
                { data: 'norm' },
                { data: 'nama' },
                { data: 'alamat' },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        let jsonRow = JSON.stringify(row);
                        return `
                            <button class="btn btn-secondary btn-sm" onclick="cetakKartu(${data})">Cetak Kartu</button>
                            <button class="btn btn-warning btn-sm" onclick='modalEdit(${jsonRow})'>Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="hapusData(${data})">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });

    function modalTambah() {
        $('#globalModal .modal-content').html($('#modalTemplate').html());
        $('#globalModal').modal('show');
    }

    function modalEdit(row) {
        $('#globalModal .modal-content').html($('#modalTemplate').html());
        var $modal = $('#globalModal');
        $modal.find('#inputId').val(row.id);
        $modal.find('#inputNama').val(row.nama);
        $modal.find('#inputNorm').val(row.norm);
        $modal.find('#inputAlamat').val(row.alamat);
        $modal.modal('show');
    }

    function simpanData() {
        var $modal = $('#globalModal');
        var nama = $modal.find('#inputNama').val().trim();
        var norm = $modal.find('#inputNorm').val().trim();
        var alamat = $modal.find('#inputAlamat').val().trim();

        if (nama === "" || norm === "" || alamat === "") {
            Swal.fire('Wajib Diisi', 'Semua kolom (Nama, No RM, Alamat) harus diisi!', 'warning');
            return;
        }

        $.post("<?= base_url('pasien/save') ?>", $modal.find('#formPasien').serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire('Berhasil', res.msg, 'success');
                $('#globalModal').modal('hide');
                table.ajax.reload();
            } else {
                Swal.fire('Error', res.msg, 'error');
            }
        });
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Hapus?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya'
        }).then((res) => {
            if (res.isConfirmed) {
                $.post("<?= base_url('pasien/delete') ?>", {id: id}, function() {
                    table.ajax.reload();
                });
            }
        });
    }

    function importData() {
        Swal.fire({title: 'Importing...', didOpen: () => Swal.showLoading()});
        $.get("<?= base_url('pasien/import') ?>", function(res) {
            Swal.close();
            Swal.fire('Selesai', res.msg, 'success');
            table.ajax.reload();
        });
    }

    function cetakKartu(id) {
        // Membuka popup ukuran kartu nama
        window.open("<?= base_url('pasien/cetak') ?>/" + id, "_blank", "width=400,height=300");
    }
</script>
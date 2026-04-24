<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">Data Kunjungan (Poli)</h5>
        <?php if(session('role') != 'perawat'): ?>
            <button class="btn btn-primary btn-sm" onclick="modalTambah()">+ Kunjungan Baru</button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <table id="tableKunjungan" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>Tgl Kunjungan</th>
                    <th>No Reg</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kunjungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="modalTemplateKunjungan" style="display:none;">
    <div class="modal-header">
        <h5 class="modal-title">Form Kunjungan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <form id="formKunjungan">
            <input type="hidden" name="id" id="inputId">
            
            <div class="mb-3">
                <label>Pilih Pendaftaran (Pasien)</label>
                <select class="form-control" name="pendaftaranpasienid" id="inputPendId">
                    <option value="">-- Loading --</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Jenis Kunjungan / Poli</label>
                <select class="form-control" name="jeniskunjungan" id="inputJenis">
                    <option value="Poli Umum">Poli Umum</option>
                    <option value="Poli Gigi">Poli Gigi</option>
                    <option value="IGD">IGD</option>
                    <option value="Konsultasi">Konsultasi</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Tanggal Kunjungan</label>
                <input type="date" class="form-control" name="tglkunjungan" id="inputTgl" value="<?= date('Y-m-d') ?>">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="simpanData()">Simpan</button>
    </div>
</div>

<script>
    var tableKunj;
    $(document).ready(function() {
        tableKunj = $('#tableKunjungan').DataTable({
            ajax: "<?= base_url('kunjungan/read') ?>",
            columns: [
                { data: 'tglkunjungan' },
                { data: 'noregistrasi' }, 
                { data: 'nama_pasien' },  
                { data: 'jeniskunjungan' },
                { 
                    data: 'id',
                    render: function(data, type, row) {
                        // Tombol Cetak Tiket
                        let btnCetak = `<button class="btn btn-secondary btn-sm me-1" onclick="cetakTiket(${data})">Tiket</button>`;
                        
                        // Perawat hanya lihat tombol cetak
                        if('<?= session('role') ?>' == 'perawat') return btnCetak;
                        
                        let jsonRow = JSON.stringify(row);
                        return btnCetak + `
                        <button class="btn btn-warning btn-sm" onclick='editData(${jsonRow})'>Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="hapus(${data})">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });

    function modalTambah() {
        $('#globalModal .modal-content').html($('#modalTemplateKunjungan').html());
        $('#globalModal').modal('show');
        loadDropdown();
    }

    function editData(row) {
        $('#globalModal .modal-content').html($('#modalTemplateKunjungan').html());
        
        var $modal = $('#globalModal');
        $modal.find('#inputId').val(row.id);
        $modal.find('#inputJenis').val(row.jeniskunjungan);
        $modal.find('#inputTgl').val(row.tglkunjungan);
        $modal.modal('show');

        // Load dropdown dulu baru set value
        var $select = $modal.find('#inputPendId');
        $.get("<?= base_url('kunjungan/listPendaftaran') ?>", function(res){
            let opts = '<option value="">-- Pilih No Reg --</option>';
            res.forEach(r => { opts += `<option value="${r.id}">${r.noregistrasi} - ${r.nama}</option>`; });
            $select.html(opts);
            $select.val(row.pendaftaranpasienid); // Set terpilih
        });
    }

    function loadDropdown() {
        var $select = $('#globalModal').find('#inputPendId');
        $.get("<?= base_url('kunjungan/listPendaftaran') ?>", function(res){
            let opts = '<option value="">-- Pilih No Reg --</option>';
            res.forEach(r => { opts += `<option value="${r.id}">${r.noregistrasi} - ${r.nama}</option>`; });
            $select.html(opts);
        });
    }

    function simpanData() {
        $.post("<?= base_url('kunjungan/save') ?>", $('#globalModal').find('#formKunjungan').serialize(), function(res){
            if(res.status == 'success') {
                $('#globalModal').modal('hide');
                tableKunj.ajax.reload();
                Swal.fire('Sukses', res.msg, 'success');
            } else { Swal.fire('Gagal', res.msg, 'error'); }
        });
    }

    function hapus(id) {
        if(confirm('Hapus?')) {
            $.post("<?= base_url('kunjungan/delete') ?>", {id:id}, function(){ tableKunj.ajax.reload(); });
        }
    }

    function cetakTiket(id) {
        // Popup bentuk tiket A5
        window.open("<?= base_url('kunjungan/cetak') ?>/" + id, "_blank", "width=600,height=500");
    }
</script>
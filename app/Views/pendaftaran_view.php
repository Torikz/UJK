<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">Data Pendaftaran</h5>
        <?php if(session('role') != 'perawat'): ?>
        <button class="btn btn-primary btn-sm" onclick="modalTambah()">+ Daftar Baru</button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <table id="tablePendaftaran" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>No Reg</th>
                    <th>Nama Pasien</th>
                    <th>No RM</th>
                    <th>Tgl Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="modalTemplate" style="display:none;">
    <div class="modal-header">
        <h5 class="modal-title">Form Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <form id="formPendaftaran">
            <input type="hidden" name="id" id="inputId">
            
            <div class="mb-3">
                <label>Pilih Pasien</label>
                <select class="form-control" name="pasienid" id="inputPasienId">
                    <option value="">-- Loading... --</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>No Registrasi</label>
                <input type="text" class="form-control" name="noregistrasi" id="inputNoReg" value="REG-<?= date('YmdHis') ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" class="form-control" name="tglregistrasi" id="inputTgl" value="<?= date('Y-m-d') ?>">
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
        table = $('#tablePendaftaran').DataTable({
            ajax: "<?= base_url('pendaftaran/read') ?>",
            columns: [
                { data: 'noregistrasi' },
                { data: 'nama_pasien' },
                { data: 'norm' },
                { data: 'tglregistrasi' },
                { 
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                        <button class="btn btn-secondary btn-sm" onclick="cetakStruk(${data})">Struk</button>
                        <button class="btn btn-danger btn-sm" onclick="hapus(${data})">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });

    function modalTambah() {
        $('#globalModal .modal-content').html($('#modalTemplate').html());
        $('#globalModal').modal('show');

        // Load Dropdown Pasien Realtime
        var $select = $('#globalModal').find('#inputPasienId');
        $.get("<?= base_url('pendaftaran/listPasien') ?>", function(res) {
            let opts = '<option value="">-- Pilih Pasien --</option>';
            if (res.length > 0) {
                res.forEach(p => { opts += `<option value="${p.id}">${p.norm} - ${p.nama}</option>`; });
            }
            $select.html(opts);
        });
    }

    function simpanData() {
        var formData = $('#globalModal').find('#formPendaftaran').serialize();
        $.post("<?= base_url('pendaftaran/save') ?>", formData, function(res){
            if(res.status == 'success') {
                $('#globalModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses', res.msg, 'success');
            } else { Swal.fire('Gagal', res.msg, 'error'); }
        });
    }

    function hapus(id) {
        if(confirm('Hapus data?')) {
            $.post("<?= base_url('pendaftaran/delete') ?>", {id:id}, function(){
                table.ajax.reload();
            });
        }
    }

    function cetakStruk(id) {
        // Popup bentuk struk panjang
        window.open("<?= base_url('pendaftaran/cetak') ?>/" + id, "_blank", "width=350,height=500");
    }
</script>
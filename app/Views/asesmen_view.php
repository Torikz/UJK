<div class="card border-primary shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h5 class="mb-0">Data Asesmen & Diagnosis</h5>
        <?php if(session('role') != 'admisi'): ?>
        <button class="btn btn-light text-primary btn-sm fw-bold" onclick="modalTambah()">+ Input Asesmen</button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <table id="tableAsesmen" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>Tgl</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan Utama</th>
                    <th>Keluhan Tambahan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="modalTemplateAsesmen" style="display:none;">
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Form Asesmen Medis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <form id="formAsesmen">
            <input type="hidden" name="id" id="inputId">
            
            <div class="mb-3">
                <label class="fw-bold">Pilih Kunjungan Pasien</label>
                <select class="form-control" name="kunjunganid" id="inputKunjunganId">
                    <option value="">-- Sedang Memuat Data... --</option>
                </select>
                <small class="text-muted">Data diambil dari Menu Kunjungan (Poli).</small>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold">Keluhan Utama</label>
                <textarea class="form-control" name="keluhan_utama" id="inputKU" rows="2" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold">Diagnosis / Tambahan</label>
                <textarea class="form-control" name="keluhan_tambahan" id="inputKT" rows="3"></textarea>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="simpanData()">Simpan Rekam Medis</button>
    </div>
</div>

<script>
    var tableAses;
    $(document).ready(function() {
        tableAses = $('#tableAsesmen').DataTable({
            ajax: "<?= base_url('asesmen/read') ?>",
            columns: [
                { data: 'tglkunjungan' },
                { data: 'nama_pasien' },
                { data: 'keluhan_utama' },
                { data: 'keluhan_tambahan' },
                { 
                    data: 'id',
                    render: function(data, type, row) {
                        let jsonRow = JSON.stringify(row);
                        return `
                        <button class="btn btn-secondary btn-sm" onclick="cetakResume(${data})">Resume</button>
                        <button class="btn btn-warning btn-sm" onclick='editData(${jsonRow})'>Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="hapus(${data})">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });

    function modalTambah() {
        $('#globalModal .modal-content').html($('#modalTemplateAsesmen').html());
        $('#globalModal').modal('show');
        loadKunjungan(null);
    }

    function editData(row) {
        $('#globalModal .modal-content').html($('#modalTemplateAsesmen').html());
        var $modal = $('#globalModal');
        
        $modal.find('#inputId').val(row.id);
        $modal.find('#inputKU').val(row.keluhan_utama);
        $modal.find('#inputKT').val(row.keluhan_tambahan);
        $modal.modal('show');
        
        loadKunjungan(row.kunjunganid); // Load dropdown dan set selected value
    }

    function loadKunjungan(selectedValue) {
        var $select = $('#globalModal').find('#inputKunjunganId');
        $select.html('<option value="">-- Sedang Memuat... --</option>');

        $.get("<?= base_url('asesmen/listKunjungan') ?>", function(res){
            let opts = '<option value="">-- Pilih Pasien (Kunjungan) --</option>';
            if(res.length > 0) {
                res.forEach(r => {
                    opts += `<option value="${r.id}">[${r.tglkunjungan}] ${r.nama_pasien} - ${r.jeniskunjungan}</option>`;
                });
            }
            $select.html(opts);
            if(selectedValue) $select.val(selectedValue);
        });
    }

    function simpanData() {
        var formData = $('#globalModal').find('#formAsesmen').serialize();
        $.post("<?= base_url('asesmen/save') ?>", formData, function(res){
            if(res.status == 'success') {
                $('#globalModal').modal('hide');
                tableAses.ajax.reload();
                Swal.fire('Tersimpan', res.msg, 'success');
            } else { Swal.fire('Gagal', res.msg, 'error'); }
        });
    }

    function hapus(id) {
        if(confirm('Hapus Rekam Medis ini?')) {
            $.post("<?= base_url('asesmen/delete') ?>", {id:id}, function(){ tableAses.ajax.reload(); });
        }
    }

    function cetakResume(id) {
        // Popup Resume Medis Formal
        window.open("<?= base_url('asesmen/cetak') ?>/" + id, "_blank", "width=850,height=800");
    }
</script>
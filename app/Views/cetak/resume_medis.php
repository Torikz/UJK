<!DOCTYPE html>
<html>
<head>
    <title>Resume Medis</title>
    <style>
        body { font-family: 'Times New Roman', serif; padding: 40px; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        h2 { margin: 0; text-transform: uppercase; }
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .meta-table td { padding: 5px; }
        .content-box { border: 1px solid #000; padding: 15px; margin-bottom: 20px; min-height: 100px; }
        .title-box { background: #eee; border: 1px solid #000; padding: 5px; font-weight: bold; margin-bottom: -1px; }
        .ttd { float: right; text-align: center; margin-top: 50px; width: 200px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>KLINIK SEHAT TERPADU</h2>
        <p>Jl. Kesehatan Raya No. 123, Jakarta | Email: info@kliniksehat.com</p>
        <h3>CATATAN REKAM MEDIS (ASESMEN)</h3>
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%">Nama Pasien</td><td width="35%">: <b><?= $row['nama'] ?></b></td>
            <td width="15%">Tanggal</td><td width="35%">: <?= date('d F Y', strtotime($row['tglkunjungan'])) ?></td>
        </tr>
        <tr>
            <td>No RM</td><td>: <?= $row['norm'] ?></td>
            <td>Poli</td><td>: <?= $row['jeniskunjungan'] ?></td>
        </tr>
    </table>

    <div class="title-box">KELUHAN UTAMA (ANAMNESA)</div>
    <div class="content-box">
        <?= nl2br($row['keluhan_utama']) ?>
    </div>

    <div class="title-box">DIAGNOSA / KELUHAN TAMBAHAN</div>
    <div class="content-box">
        <?= nl2br($row['keluhan_tambahan']) ?>
    </div>

    <div class="ttd">
        <p>Dokter / Pemeriksa,</p>
        <br><br><br>
        <p>( ...................................... )</p>
    </div>
</body>
</html>
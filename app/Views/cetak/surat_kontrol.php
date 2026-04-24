<!DOCTYPE html>
<html>
<head>
    <title>Tiket Poli</title>
    <style>
        body { font-family: Helvetica, sans-serif; padding: 20px; }
        .box { border: 2px solid #333; width: 100%; max-width: 500px; padding: 20px; margin: auto; }
        .poli-title { font-size: 24pt; font-weight: bold; text-align: center; border: 2px solid #000; padding: 10px; margin: 10px 0; }
        .info { font-size: 12pt; margin-top: 20px; }
        table { width: 100%; }
        td { padding: 5px; vertical-align: top; }
    </style>
</head>
<body onload="window.print()">
    <div class="box">
        <center>
            <h3>TIKET ANTRIAN POLI</h3>
            <p><?= date('l, d F Y', strtotime($row['tglkunjungan'])) ?></p>
        </center>
        
        <div class="poli-title">
            <?= strtoupper($row['jeniskunjungan']) ?>
        </div>

        <div class="info">
            <table>
                <tr><td width="30%">Nama Pasien</td><td>: <b><?= $row['nama'] ?></b></td></tr>
                <tr><td>No RM</td><td>: <?= $row['norm'] ?></td></tr>
                <tr><td>No Registrasi</td><td>: <?= $row['noregistrasi'] ?></td></tr>
            </table>
        </div>
        <br><br>
        <center style="font-size: 10pt;">Silahkan menuju ruang tunggu poli.</center>
    </div>
</body>
</html>
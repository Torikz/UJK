<!DOCTYPE html>
<html>
<head>
    <title>Cetak Pendaftaran</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { border: 1px solid #000; padding: 20px; width: 300px; margin: auto; }
        h3 { text-align: center; margin-bottom: 5px; }
        table { width: 100%; }
        td { padding: 5px; }
    </style>
</head>
<body onload="window.print()">
    <div class="box">
        <h3>KLINIK SEHAT</h3>
        <p style="text-align: center;">Bukti Pendaftaran</p>
        <hr>
        <table>
            <tr>
                <td>No. Reg</td>
                <td>: <b><?= $row['noregistrasi'] ?></b></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= $row['tglregistrasi'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <?= $row['nama'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= $row['alamat'] ?></td>
            </tr>
        </table>
        <br>
        <p style="text-align: center; font-size: 12px;">Harap simpan bukti ini.</p>
    </div>
</body>
</html>
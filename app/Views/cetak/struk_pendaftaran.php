<!DOCTYPE html>
<html>
<head>
    <title>Bukti Daftar</title>
    <style>
        body { font-family: monospace; margin: 0; padding: 10px; width: 80mm; } /* Ukuran Printer Thermal */
        .struk { border: 1px dashed #333; padding: 10px; }
        h3, p { text-align: center; margin: 2px 0; }
        hr { border-top: 1px dashed #333; }
        table { width: 100%; font-size: 10pt; }
        td { padding: 2px; }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <h3>KLINIK SEHAT</h3>
        <p>BUKTI REGISTRASI</p>
        <hr>
        <table>
            <tr><td>No Reg</td><td>: <b><?= $row['noregistrasi'] ?></b></td></tr>
            <tr><td>Tanggal</td><td>: <?= date('d/m/Y', strtotime($row['tglregistrasi'])) ?></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>No RM</td><td>: <?= $row['norm'] ?></td></tr>
            <tr><td>Nama</td><td>: <?= $row['nama'] ?></td></tr>
        </table>
        <hr>
        <p style="font-size: 8pt;">Harap menunggu panggilan.</p>
        <p style="font-size: 8pt;">Terima Kasih.</p>
    </div>
</body>
</html>
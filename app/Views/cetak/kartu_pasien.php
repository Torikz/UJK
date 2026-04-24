<!DOCTYPE html>
<html>
<head>
    <title>Kartu Pasien</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px; }
        .card {
            width: 85.6mm; height: 53.98mm; /* Ukuran Standar ID Card / KTP */
            border: 1px solid #000; border-radius: 8px; padding: 15px;
            position: relative; background: #fdfdfd;
        }
        .header { text-align: center; border-bottom: 2px solid #004085; padding-bottom: 5px; margin-bottom: 10px; }
        .header h3 { margin: 0; color: #004085; font-size: 14pt; text-transform: uppercase; }
        .header p { margin: 0; font-size: 8pt; color: #555; }
        .content { font-size: 10pt; }
        .row { margin-bottom: 5px; display: flex; }
        .label { width: 80px; font-weight: bold; color: #333; }
        .value { flex: 1; }
        .footer { position: absolute; bottom: 10px; right: 15px; font-size: 7pt; color: #777; }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        <div class="header">
            <h3>KLINIK SEHAT TERPADU</h3>
            <p>Jl. Kesehatan No. 123, Jakarta Selatan | Telp: (021) 555-777</p>
        </div>
        <div class="content">
            <div class="row"><span class="label">No RM</span> <span class="value">: <?= $row['norm'] ?></span></div>
            <div class="row"><span class="label">Nama</span> <span class="value">: <?= strtoupper($row['nama']) ?></span></div>
            <div class="row"><span class="label">Alamat</span> <span class="value">: <?= $row['alamat'] ?></span></div>
        </div>
        <div class="footer">Dicetak pada: <?= date('d-m-Y H:i') ?></div>
    </div>
</body>
</html>
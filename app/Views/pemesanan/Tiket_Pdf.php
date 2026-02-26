<!DOCTYPE html>
<html>
<head>
    <title>Tiket Konser</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
        }

        .ticket {
            width: 100%;
            border: 2px dashed #333;
            background: #fff;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            letter-spacing: 2px;
        }

        .content {
            width: 100%;
        }

        .left {
            width: 65%;
            float: left;
        }

        .right {
            width: 30%;
            float: right;
            text-align: center;
            border-left: 1px dashed #ccc;
            padding-left: 10px;
        }

        .info {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .ticket-code {
            margin-top: 15px;
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .qr {
            border: 1px solid #000;
            padding: 25px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .footer {
            clear: both;
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="ticket">

    <div class="header">
        <h2>TIKET KONSER</h2>
        <small>Valid untuk 1 kali masuk</small>
    </div>

    <div class="content">
        <div class="left">
            <div class="info">
                <span class="label">Nama Konser</span>: <?= $p['name_konser'] ?>
            </div>
            <div class="info">
                <span class="label">Lokasi</span>: <?= $p['lokasi'] ?>
            </div>
            <div class="info">
                <span class="label">Tanggal</span>: <?= $p['tanggal'] ?>
            </div>
            <div class="info">
                <span class="label">Jumlah Tiket</span>: <?= $p['jumlah_tiket'] ?>
            </div>
            <div class="info">
                <span class="label">Total Bayar</span>: Rp <?= number_format($p['total_harga']) ?>
            </div>
            <div class="info">
                <span class="label">Status</span>: <?= strtoupper($p['status']) ?>
            </div>

            <div class="ticket-code">
                KODE TIKET<br>
                <?= strtoupper('TKT-' . $p['id']) ?>
            </div>
        </div>

        <div class="right">
            <div class="qr">
                QR CODE<br>
                (Simulasi)
            </div>
            <small>Scan di pintu masuk</small>
        </div>
    </div>

    <div class="footer">
        © <?= date('Y') ?> Sistem Pemesanan Tiket Konser<br>
        Tiket ini bersifat digital & tidak dapat dipindahtangankan
    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center">

<div class="bg-slate-800 p-8 rounded-xl shadow max-w-md w-full text-center">

    <h2 class="text-2xl font-bold text-green-400 mb-4">
        🎫 E-Ticket Berhasil Dibuat
    </h2>

    <p class="mb-2">Nama Konser:</p>
    <p class="font-bold text-purple-400 mb-4">
        <?= $pesanan['name_konser'] ?>
    </p>

    <p>Jumlah Tiket: <?= $pesanan['jumlah_tiket'] ?></p>
    <p class="mb-4">
        Total Bayar:
        <span class="text-green-400 font-bold">
            Rp <?= number_format($pesanan['total_harga']) ?>
        </span>
    </p>

    <div class="bg-green-500/20 text-green-400 p-3 rounded mb-4">
        Status: PAID
    </div>

    <a href="/pesanan-saya" 
       class="inline-block bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
        Kembali ke Riwayat
    </a>

</div>
</body>
</html>

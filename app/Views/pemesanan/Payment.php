<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<div class="max-w-xl mx-auto mt-20 bg-slate-800 p-8 rounded-xl shadow">

    <h2 class="text-2xl font-bold text-purple-400 mb-6">
        Pembayaran Tiket
    </h2>

    <p>Konser: <b><?= $pesanan['name_konser'] ?></b></p>
    <p>Jumlah Tiket: <?= $pesanan['jumlah_tiket'] ?></p>
    <p class="mb-4">Total:
        <b class="text-green-400">
            Rp <?= number_format($pesanan['total_harga']) ?>
        </b>
    </p>

    <!-- HARUS KE PEMESANAN -->
    <form action="/pemesanan/process/<?= $pesanan['id'] ?>" method="post">
        <button 
            class="w-full bg-green-600 hover:bg-green-700 py-3 rounded font-bold">
            Bayar Sekarang
        </button>
    </form>

    <a href="/pesanan-saya" 
       class="block text-center mt-4 text-slate-400">
        ← Kembali
    </a>

</div>
</body>
</html>

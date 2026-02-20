<!DOCTYPE html>
<html>
<head>
    <title>Detail Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- NAVBAR GLOBAL -->
<?= view('layout/navbar') ?>

<div class="max-w-xl mx-auto mt-20 bg-slate-800 p-8 rounded-xl shadow">
    <h2 class="text-3xl font-bold text-purple-400 mb-4">
        <?= $konser['name_konser'] ?>
    </h2>

    <p>📍 Lokasi: <?= $konser['lokasi'] ?></p>
    <p>📅 Tanggal: <?= $konser['tanggal'] ?></p>
    <p>💰 Harga: Rp <?= number_format($konser['harga']) ?></p>
    <p>🎟 Sisa tiket: <?= $konser['jumlah_bed'] ?></p>

    <?php if ($konser['jumlah_bed'] > 0): ?>

        <?php if (session()->get('logged_in')): ?>
            <!-- USER SUDAH LOGIN -->
            <a href="/pesan/<?= $konser['id'] ?>" 
               class="block text-center mt-6 bg-purple-600 hover:bg-purple-700 py-3 rounded font-bold">
               Pesan Tiket
            </a>
        <?php else: ?>
            <!-- GUEST (BELUM LOGIN) -->
            <a href="/login" 
               class="block text-center mt-6 bg-purple-600 hover:bg-purple-700 py-3 rounded font-bold">
               Pesan Tiket
            </a>
            <p class="text-slate-400 mt-2 text-sm text-center">
                *Silakan login terlebih dahulu untuk memesan tiket
            </p>
        <?php endif; ?>

    <?php else: ?>
        <p class="text-red-400 mt-4">Tiket habis</p>
    <?php endif; ?>

    <a href="/konser" class="block text-center mt-4 text-slate-400 hover:text-white">
        ← Kembali ke Konser
    </a>
</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- NAVBAR GLOBAL -->
<?= view('layout/navbar') ?>

<div class="max-w-xl mx-auto mt-16 bg-slate-800 p-8 rounded-xl shadow">

    <!-- GAMBAR KONSER -->
    <?php if (!empty($konser['gambar'])): ?>
        <img 
            src="/uploads/gambar/<?= $konser['gambar'] ?>" 
            alt="<?= $konser['name_konser'] ?>"
            class="w-full h-64 object-cover rounded-lg mb-6 shadow"
        >
    <?php else: ?>
        <!-- Jika konser lama belum punya gambar -->
        <div class="w-full h-64 bg-slate-700 rounded-lg mb-6 flex items-center justify-center text-slate-400">
            Tidak ada gambar konser
        </div>
    <?php endif; ?>

    <h2 class="text-3xl font-bold text-purple-400 mb-4">
        <?= $konser['name_konser'] ?>
    </h2>

    <p class="mb-2">📍 Lokasi: <?= $konser['lokasi'] ?></p>
    <p class="mb-2">📅 Tanggal: <?= $konser['tanggal'] ?></p>
    <p class="mb-2">💰 Harga: Rp <?= number_format($konser['harga']) ?></p>
    <p class="mb-4">🎟 Sisa tiket: <?= $konser['jumlah_bed'] ?></p>

    <?php if ($konser['jumlah_bed'] > 0): ?>
        <a href="/pesan/<?= $konser['id'] ?>" 
           class="block text-center mt-6 bg-purple-600 hover:bg-purple-700 py-3 rounded font-semibold">
           Pesan Tiket
        </a>
    <?php else: ?>
        <p class="text-red-400 mt-4 text-center font-semibold">
            Tiket habis
        </p>
    <?php endif; ?>

    <a href="/konser" class="block text-center mt-6 text-slate-400 hover:text-white">
        ← Kembali ke Konser
    </a>
</div>

</body>
</html>

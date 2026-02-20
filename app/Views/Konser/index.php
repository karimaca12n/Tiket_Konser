<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket | Daftar Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white">

<!-- PANGGIL NAVBAR GLOBAL -->
<?= view('layout/navbar') ?>

<!-- Hero -->
<section class="text-center py-20 bg-gradient-to-b from-purple-900 to-slate-900">
    <h2 class="text-4xl font-bold mb-4">Find Your Next Concert 🎶</h2>
    <p class="text-slate-300">Pesan tiket konser favoritmu dengan mudah</p>
</section>

<!-- List Konser -->
<section class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

<?php foreach($konser as $k): ?>
<div class="bg-slate-800 rounded-xl overflow-hidden shadow-lg hover:scale-105 transition">

    <img 
        src="<?= base_url('uploads/gambar/' . $k['gambar']) ?>" 
        alt="<?= $k['name_konser'] ?>"
        class="w-full h-48 object-cover rounded-lg mb-3">

    <div class="p-6">
        <h3 class="text-xl font-bold text-purple-400 mb-2">
            <?= $k['name_konser'] ?>
        </h3>
        <p class="text-slate-300">📍 <?= $k['lokasi'] ?></p>
        <p class="text-slate-300">📅 <?= $k['tanggal'] ?></p>
        <p class="text-slate-300">💰 Rp <?= number_format($k['harga']) ?></p>
        <p class="text-slate-400 text-sm">
            Sisa tiket: <?= $k['jumlah_bed'] ?>
        </p>

        <a href="/konser/<?= $k['id'] ?>" 
           class="inline-block mt-4 bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded font-semibold">
           Lihat Detail
        </a>
    </div>
</div>
<?php endforeach; ?>

</section>

</body>
</html>

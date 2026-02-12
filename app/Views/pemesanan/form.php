<!DOCTYPE html>
<html>
<head>
    <title>Pesan Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<div class="max-w-xl mx-auto mt-20 bg-slate-800 p-8 rounded-xl shadow">

    <h2 class="text-2xl font-bold text-purple-400 mb-6">
        Pesan Tiket Konser
    </h2>

    <div class="space-y-2 text-slate-300">
        <p><strong>Konser:</strong> <?= $konser['name_konser'] ?></p>
        <p><strong>Lokasi:</strong> <?= $konser['lokasi'] ?></p>
        <p><strong>Tanggal:</strong> <?= $konser['tanggal'] ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($konser['harga']) ?></p>
        <p><strong>Sisa Tiket:</strong> <?= $konser['jumlah_bed'] ?></p>
    </div>

    <form action="/pesan/submit" method="post" class="mt-6 space-y-4">
        <input type="hidden" name="konser_id" value="<?= $konser['id'] ?>">

        <div>
            <label class="block mb-1">Jumlah Tiket</label>
            <input 
                type="number" 
                name="jumlah" 
                min="1" 
                max="<?= $konser['jumlah_bed'] ?>" 
                required
                class="w-full px-4 py-2 rounded bg-slate-700 text-white focus:outline-none"
            >
        </div>

        <button type="submit" 
            class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded font-bold">
            Pesan Sekarang
        </button>
    </form>

    <a href="/konser/<?= $konser['id'] ?>" 
       class="block text-center mt-4 text-slate-400 hover:text-white">
       ← Kembali ke Detail
    </a>
</div>

</body>
</html>

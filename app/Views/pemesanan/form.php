<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesan Tiket | <?= esc($konser['name_konser']) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7f13ec",
                        "background-light": "#f7f6f8",
                        "background-dark": "#191022",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 dark:bg-slate-900 text-white dark:text-white transition-colors duration-300">

<!-- NAVBAR -->
<?= view('layout/navbar') ?>

<main class="max-w-2xl mx-auto px-6 py-12">
    <!-- Back Button -->
    <a href="/konser/<?= $konser['id'] ?>" class="inline-flex items-center gap-2 text-slate-400 hover:text-primary transition-colors mb-8">
        <span class="material-icons">arrow_back</span>
        <span class="font-semibold">Kembali ke Detail</span>
    </a>

    <!-- Form Card -->
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-8 md:p-12">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-8">Pesan Tiket Konser</h1>

        <!-- Concert Info -->
        <div class="bg-slate-900 rounded-xl p-6 mb-8 border border-slate-700 space-y-3">
            <div class="flex justify-between">
                <span class="text-slate-400">Konser</span>
                <span class="font-semibold text-primary"><?= esc($konser['name_konser']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Lokasi</span>
                <span class="font-semibold text-white"><?= esc($konser['lokasi']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Tanggal</span>
                <span class="font-semibold text-white"><?= esc($konser['tanggal']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Harga per Tiket</span>
                <span class="font-semibold text-primary">Rp <?= number_format($konser['harga']) ?></span>
            </div>
            <div class="flex justify-between pt-3 border-t border-slate-700">
                <span class="text-slate-400">Sisa Tiket</span>
                <span class="font-semibold text-white"><?= $konser['jumlah_bed'] ?> tiket</span>
            </div>
        </div>

        <!-- Form -->
        <form action="/pesan/submit" method="post" class="space-y-6">
            <input type="hidden" name="konser_id" value="<?= $konser['id'] ?>">

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Jumlah Tiket</label>
                <input 
                    type="number" 
                    name="jumlah" 
                    min="1" 
                    max="<?= $konser['jumlah_bed'] ?>" 
                    required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                    placeholder="Minimum 1"
                >
            </div>

            <button type="submit" class="w-full py-4 bg-primary hover:bg-primary/90 text-white font-bold text-lg rounded-xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2">
                <span class="material-icons">shopping_cart</span>
                Lanjut ke Pembayaran
            </button>
        </form>
    </div>
</main>

</body>
</html>

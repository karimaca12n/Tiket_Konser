<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Konser | <?= esc($konser['name_konser']) ?></title>
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
    <!-- Back Button & Title -->
    <a href="/konser" class="inline-flex items-center gap-2 text-slate-400 hover:text-primary transition-colors mb-8">
        <span class="material-icons">arrow_back</span>
        <span class="font-semibold">Kembali ke Konser</span>
    </a>

    <!-- Hero Image -->
    <div class="relative w-full rounded-2xl overflow-hidden mb-8 shadow-2xl">
        <?php if (!empty($konser['gambar'])): ?>
            <img 
                src="/uploads/gambar/<?= esc($konser['gambar']) ?>" 
                alt="<?= esc($konser['name_konser']) ?>"
                class="w-full h-96 object-cover"
            >
        <?php else: ?>
            <div class="w-full h-96 bg-slate-700 rounded-lg flex items-center justify-center text-slate-400">
                Tidak ada gambar konser
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent"></div>
    </div>

    <!-- Detail Card -->
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-8 md:p-12 mb-8">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/20 text-primary text-xs font-bold mb-4 tracking-wider uppercase">
            <span class="material-icons text-sm">confirmation_number</span>
            Music Concert
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
            <?= esc($konser['name_konser']) ?>
        </h1>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-slate-700">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <span class="material-icons">calendar_today</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Tanggal</p>
                    <p class="text-lg font-semibold text-white"><?= esc($konser['tanggal']) ?></p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <span class="material-icons">schedule</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Waktu</p>
                    <p class="text-lg font-semibold text-white">20:00 WIB</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                    <span class="material-icons">location_on</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Lokasi</p>
                    <p class="text-lg font-semibold text-white"><?= esc($konser['lokasi']) ?></p>
                </div>
            </div>
        </div>

        <!-- Price & Stock -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-sm text-slate-400 mb-2">Harga Tiket</p>
                <p class="text-3xl font-bold text-primary">Rp <?= number_format($konser['harga']) ?></p>
            </div>
            <div>
                <p class="text-sm text-slate-400 mb-2">Sisa Tiket</p>
                <p class="text-3xl font-bold text-white"><?= esc($konser['jumlah_bed']) ?> tiket</p>
            </div>
        </div>

        <!-- CTA Button -->
        <?php if ($konser['jumlah_bed'] > 0): ?>
            <a href="/pesan/<?= $konser['id'] ?>" 
               class="block w-full text-center py-4 bg-primary hover:bg-primary/90 text-white font-bold text-lg rounded-xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2">
                <span class="material-icons">shopping_cart</span>
                Beli Tiket Sekarang
            </a>
        <?php else: ?>
            <div class="block w-full text-center py-4 bg-slate-700 text-slate-300 font-bold text-lg rounded-xl">
                Tiket Habis
            </div>
        <?php endif; ?>
    </div>

    <!-- Description Section -->
    <?php if (!empty($konser['deskripsi'])): ?>
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-8 md:p-12">
        <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary rounded-full"></span>
            Tentang Acara
        </h2>
        <p class="text-slate-300 leading-relaxed">
            <?= nl2br(esc($konser['deskripsi'])) ?>
        </p>
    </div>
    <?php endif; ?>
</main>

</body>
</html>

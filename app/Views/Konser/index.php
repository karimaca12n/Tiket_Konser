<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SoraiFest - Nikmati Musik Favoritmu</title>
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

<!-- Hero Section -->
<section class="relative pt-20 pb-16 overflow-hidden">
    <div class="container mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-xs font-bold mb-6 tracking-wider uppercase">
            <span class="material-icons text-sm">confirmation_number</span>
            Edisi Konser Terbatas 2026
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold text-white dark:text-white mb-6 leading-tight">
            Nikmati Musik <br/>
            <span class="text-primary">Favoritmu</span>
        </h1>
        <p class="text-slate-300 dark:text-slate-300 text-lg max-w-2xl mx-auto mb-12 leading-relaxed">
            Temukan konser terbaik dari artis internasional dan lokal. Amankan tiketmu sekarang sebelum kehabisan dalam hitungan menit.
        </p>
    </div>
</section>

<!-- Event Grid -->
<section class="container mx-auto px-6 pb-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php foreach($konser as $k): ?>
        <!-- Event Card -->
        <div class="group bg-slate-800 dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 dark:border-slate-700 hover:shadow-2xl transition-all duration-300">
            <div class="relative h-56 overflow-hidden">
                <img alt="<?= esc($k['name_konser']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= base_url('uploads/gambar/' . $k['gambar']) ?>" />
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg flex flex-col items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase leading-none">OCT</span>
                    <span class="text-xl font-bold text-slate-900 leading-none">12</span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-white dark:text-white mb-2 line-clamp-1"><?= esc($k['name_konser']) ?></h3>
                <div class="flex items-center gap-2 text-slate-300 dark:text-slate-300 text-sm mb-4">
                    <span class="material-icons text-sm text-primary">location_on</span>
                    <span><?= esc($k['lokasi']) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400">Mulai dari</p>
                        <p class="text-lg font-bold text-primary">Rp <?= number_format($k['harga']) ?></p>
                    </div>
                    <a href="/konser/<?= $k['id'] ?>" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Newsletter / CTA -->
<section class="bg-slate-800 dark:bg-slate-800 py-16">
    <div class="container mx-auto px-6">
        <div class="bg-primary rounded-3xl p-8 md:p-16 flex flex-col md:flex-row items-center gap-8 text-center md:text-left overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
            <div class="flex-1 z-10">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Jangan Lewatkan Konser Seru Lainnya!</h2>
                <p class="text-white/80 text-lg">Dapatkan notifikasi langsung ke email Anda saat tiket artis favorit Anda tersedia.</p>
            </div>
            <div class="w-full md:w-auto z-10">
                <form class="flex flex-col sm:flex-row gap-4">
                    <input class="px-6 py-4 rounded-xl bg-white/20 border-white/20 text-white placeholder-white/60 focus:ring-white focus:border-white outline-none w-full sm:w-80" placeholder="Email Anda" type="email"/>
                    <button class="bg-white text-primary px-8 py-4 rounded-xl font-bold hover:bg-slate-100 transition-colors whitespace-nowrap shadow-xl" type="submit">Langganan</button>
                </form>
            </div>
        </div>
    </div>
</section>

</body>
</html>

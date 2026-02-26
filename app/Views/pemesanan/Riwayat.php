<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pemesanan</title>
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
<body class="bg-slate-900 dark:bg-slate-900 text-white dark:text-white transition-colors duration-300 min-h-screen">

<!-- NAVBAR -->
<?= view('layout/navbar') ?>

<main class="max-w-4xl mx-auto px-6 py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-white mb-8">Riwayat Pemesanan Saya</h1>

    <?php if (empty($pesanan)): ?>
        <!-- Empty State -->
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-12 text-center">
            <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-icons text-2xl text-slate-500">shopping_bag</span>
            </div>
            <p class="text-slate-400 text-lg">Belum ada pemesanan tiket.</p>
            <a href="/konser" class="inline-block mt-6 px-6 py-2 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition-all">
                Pesan Sekarang
            </a>
        </div>
    <?php else: ?>
        <!-- Orders List -->
        <div class="space-y-4">
            <?php foreach($pesanan as $p): ?>
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 hover:border-slate-600 transition-colors">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-sm mb-1">Konser</p>
                        <h3 class="text-lg font-bold text-primary mb-4"><?= esc($p['name_konser']) ?></h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-400">ID Pesanan</span>
                                <span class="font-semibold text-slate-300">#<?= $p['id'] ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Jumlah</span>
                                <span class="font-semibold text-slate-300"><?= $p['jumlah_tiket'] ?> tiket</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Total</span>
                                <span class="font-bold text-primary">Rp <?= number_format($p['total_harga']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between items-end">
                        <!-- Status Badge -->
                        <?php if($p['status'] == 'pending'): ?>
                            <span class="px-4 py-2 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 rounded-lg text-sm font-semibold mb-4">
                                ⏳ Menunggu Pembayaran
                            </span>
                        <?php elseif($p['status'] == 'paid'): ?>
                            <span class="px-4 py-2 bg-blue-500/20 border border-blue-500/30 text-blue-400 rounded-lg text-sm font-semibold mb-4">
                                💳 Sudah Dibayar (Menunggu Approval)
                            </span>
                        <?php elseif($p['status'] == 'approved'): ?>
                            <span class="px-4 py-2 bg-green-500/20 border border-green-500/30 text-green-400 rounded-lg text-sm font-semibold mb-4">
                                ✓ Approved - Siap Cetak
                            </span>
                        <?php else: ?>
                            <span class="px-4 py-2 bg-red-500/20 border border-red-500/30 text-red-400 rounded-lg text-sm font-semibold mb-4">
                                ✕ Dibatalkan
                            </span>
                        <?php endif ?>

                        <!-- Action Button -->
                        <?php if($p['status'] == 'pending'): ?>
                            <a href="/pemesanan/payment/<?= $p['id'] ?>" class="px-6 py-2 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition-all text-sm">
                                Lanjut Bayar
                            </a>
                        <?php elseif($p['status'] == 'paid'): ?>
                            <a href="/pemesanan/tiket/<?= $p['id'] ?>" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all text-sm cursor-not-allowed opacity-50" disabled>
                                Tunggu Approval Admin
                            </a>
                        <?php elseif($p['status'] == 'approved'): ?>
                            <a href="/pemesanan/tiket/<?= $p['id'] ?>" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all text-sm">
                                Download E-Ticket
                            </a>
                        <?php else: ?>
                            <span class="text-slate-500 text-sm">-</span>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>

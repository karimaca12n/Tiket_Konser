<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Ticket Berhasil</title>
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
<body class="bg-slate-900 dark:bg-slate-900 text-white dark:text-white transition-colors duration-300 min-h-screen flex items-center justify-center">

<div class="max-w-md w-full px-6">
    <!-- Success Card -->
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-8 text-center">
        <div class="w-16 h-16 bg-green-500/20 border-2 border-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-icons text-3xl text-green-500">check_circle</span>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Tiket Berhasil Dibuat!</h1>
        <p class="text-slate-400 mb-6">Pesanan Anda sudah dikonfirmasi dan terbayar</p>

        <!-- Order Info -->
        <div class="bg-slate-900 rounded-xl p-6 mb-6 border border-slate-700 text-left space-y-3">
            <div class="flex justify-between">
                <span class="text-slate-400">Konser:</span>
                <span class="font-semibold text-primary"><?= esc($pesanan['name_konser']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Jumlah Tiket</span>
                <span class="font-semibold text-white"><?= $pesanan['jumlah_tiket'] ?></span>
            </div>
            <div class="flex justify-between pt-3 border-t border-slate-700">
                <span class="text-slate-400">Total Bayar</span>
                <span class="font-bold text-primary">Rp <?= number_format($pesanan['total_harga']) ?></span>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 font-semibold">
            ✓ DIBAYAR
        </div>

        <!-- Action Button -->
        <div id="action-button" data-status="<?= $pesanan['status'] ?>">
            <?php if($pesanan['status'] == 'approved'): ?>
                <a href="/pemesanan/cetak/<?= $pesanan['id'] ?>" 
                class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg transition-all mb-3 inline-block text-center">
                Download E-Ticket (PDF)
                </a>
            <?php else: ?>
                <div class="block w-full py-3 bg-yellow-600 text-white font-bold rounded-lg mb-3 cursor-not-allowed text-center">
                    ⏳ Menunggu Approval Admin
                </div>
            <?php endif; ?>
        </div>

        <a href="/pesanan-saya" 
           class="block w-full py-3 bg-primary/20 hover:bg-primary/30 text-white font-bold rounded-lg transition-all">
            Lihat Riwayat Pemesanan
        </a>
    </div>
</div>

</body>
</html>

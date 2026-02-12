<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- NAVBAR USER -->
<nav class="bg-slate-800 px-8 py-4 flex justify-between">
    <h1 class="text-xl font-bold text-purple-400">SoraiFest</h1>
    <div class="space-x-4">
        <a href="/konser" class="hover:text-purple-400">Konser</a>
        <a href="/pesanan-saya" class="text-purple-400">Pesanan Saya</a>
        <a href="/logout" class="text-red-400">Logout</a>
    </div>
</nav>

<div class="max-w-5xl mx-auto mt-12">

    <h2 class="text-3xl font-bold text-purple-400 mb-6">
        Riwayat Pemesanan Saya
    </h2>

    <?php if (empty($pesanan)): ?>
        <div class="bg-slate-800 p-6 rounded text-center text-slate-400">
            Belum ada pemesanan tiket.
        </div>
    <?php else: ?>

    <div class="bg-slate-800 rounded-xl overflow-hidden shadow">
        <table class="w-full text-left">
            <thead class="bg-slate-700">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Konser</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pesanan as $p): ?>
                <tr class="border-b border-slate-700 hover:bg-slate-700">
                    <td class="p-3"><?= $p['id'] ?></td>
                    <td class="p-3"><?= $p['name_konser'] ?></td>
                    <td class="p-3"><?= $p['jumlah_tiket'] ?></td>
                    <td class="p-3">
                        Rp <?= number_format($p['total_harga']) ?>
                    </td>
                    <td class="p-3">
                        <?php if($p['status'] == 'pending'): ?>
                            <span class="bg-yellow-500 text-black px-3 py-1 rounded text-sm">
                                Pending
                            </span>
                        <?php elseif($p['status'] == 'paid'): ?>
                            <span class="bg-green-600 px-3 py-1 rounded text-sm">
                                Paid
                            </span>
                        <?php endif ?>
                    </td>

                    <td class="p-3">
                        <?php if($p['status'] == 'pending'): ?>
                            <a href="/pemesanan/payment/<?= $p['id'] ?>" 
                               class="bg-purple-600 hover:bg-purple-700 px-3 py-1 rounded text-sm">
                                Bayar
                            </a>
                        <?php elseif($p['status'] == 'paid'): ?>
                            <a href="/pemesanan/tiket/<?= $p['id'] ?>" 
                               class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm">
                                Download Tiket
                            </a>
                        <?php endif ?>
                    </td>

                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>
</div>

</body>
</html>

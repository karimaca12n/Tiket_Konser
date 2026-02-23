<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- NAVBAR GLOBAL (AUTO ADMIN / USER / GUEST) -->
<?= view('layout/navbar') ?>

<div class="max-w-5xl mx-auto mt-12 px-6">

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
                        <?php else: ?>
                            <span class="bg-red-600 px-3 py-1 rounded text-sm">
                                Cancelled
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
                        <?php else: ?>
                            <span class="text-slate-400 text-sm">-</span>
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

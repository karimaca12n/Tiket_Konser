<!DOCTYPE html>
<html>
<head>
    <title>Admin - Riwayat Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white">

<?= view('layout/navbar') ?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-slate-800 p-6 rounded-xl">
            <p class="text-slate-400">Total Omzet</p>
            <h2 class="text-2xl font-bold text-green-400">
                Rp <?= number_format($total_omzet) ?>
            </h2>
        </div>

        <div class="bg-slate-800 p-6 rounded-xl">
            <p class="text-slate-400">Total Pesanan</p>
            <h2 class="text-2xl font-bold text-blue-400">
                <?= count($pesanan) ?>
            </h2>
        </div>

        <div class="bg-slate-800 p-6 rounded-xl">
            <p class="text-slate-400 mb-2">Tiket Terjual</p>
            <?php foreach($tiket_per_konser as $t): ?>
                <p class="text-sm">
                    <?= $t['name_konser'] ?> :
                    <span class="text-purple-400 font-bold">
                        <?= $t['total_tiket'] ?>
                    </span>
                </p>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Table Riwayat -->
    <div class="bg-slate-800 rounded-xl overflow-hidden shadow">
        <table class="w-full text-sm">
            <thead class="bg-slate-700">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Konser</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Total</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pesanan as $p): ?>
                <tr class="border-b border-slate-700 hover:bg-slate-700/50">
                    <td class="p-3"><?= esc($p['username']) ?></td>
                    <td class="p-3"><?= esc($p['name_konser']) ?></td>
                    <td class="p-3 text-center"><?= $p['jumlah_tiket'] ?></td>
                    <td class="p-3 text-center">
                        Rp <?= number_format($p['total_harga']) ?>
                    </td>
                    <td class="p-3 text-center">
                        <?php if($p['status'] == 'pending'): ?>
                            <span class="bg-yellow-600 px-3 py-1 rounded text-sm">Pending</span>
                        <?php elseif($p['status'] == 'paid'): ?>
                            <span class="bg-blue-600 px-3 py-1 rounded text-sm">
                                Paid (Menunggu Approval)
                            </span>
                        <?php elseif($p['status'] == 'approved'): ?>
                            <span class="bg-green-600 px-3 py-1 rounded text-sm">Approved</span>
                        <?php elseif($p['status'] == 'cancelled'): ?>
                            <span class="bg-red-600 px-3 py-1 rounded text-sm">Cancelled</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3 text-center">
                        <?php if($p['status'] == 'paid'): ?>
                            <a href="/admin/approve/<?= $p['id'] ?>"
                               onclick="return confirm('Approve pembayaran ini?')"
                               class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm mr-2">
                               Approve
                            </a>
                            <a href="/admin/reject/<?= $p['id'] ?>"
                               onclick="return confirm('Tolak pembayaran ini?')"
                               class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                               Reject
                            </a>
                        <?php else: ?>
                            <span class="text-slate-500 text-sm">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
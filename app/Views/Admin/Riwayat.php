<!DOCTYPE html>
<html>
<head>
    <title>Admin - Riwayat Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white">

<nav class="bg-slate-800 px-8 py-4 flex justify-between">
    <h1 class="text-xl font-bold text-purple-400">Admin Panel</h1>
    <div class="space-x-4">
        <a href="/admin" class="hover:text-purple-400">Konser</a>
        <a href="/admin/riwayat" class="text-purple-400">Riwayat</a>
        <a href="/logout" class="text-red-400">Logout</a>
    </div>
</nav>

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

    <!-- Table -->
    <div class="bg-slate-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-700">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Konser</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pesanan as $p): ?>
                <tr class="border-b border-slate-700 hover:bg-slate-700/50">
                    <td class="p-3"><?= $p['username'] ?></td>
                    <td class="p-3"><?= $p['name_konser'] ?></td>
                    <td class="p-3 text-center"><?= $p['jumlah_tiket'] ?></td>
                    <td class="p-3 text-center">
                        Rp <?= number_format($p['total_harga']) ?>
                    </td>
                    <td class="p-3 text-center">
                        <?php if($p['status'] == 'paid'): ?>
                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs">Paid</span>
                        <?php elseif($p['status'] == 'pending'): ?>
                            <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs">Pending</span>
                        <?php else: ?>
                            <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs">Cancelled</span>
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

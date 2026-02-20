<!DOCTYPE html>
<html>
<head>
    <title>Admin - Kelola Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- PANGGIL NAVBAR GLOBAL (AUTO ADMIN / USER / GUEST) -->
<?= view('layout/navbar') ?>

<div class="max-w-6xl mx-auto mt-10 px-6">

    <h2 class="text-3xl font-bold text-purple-400 mb-6">
        Dashboard Admin
    </h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- ACTION BUTTON (TAMBAH + RIWAYAT) -->
    <div class="mb-6 flex flex-wrap gap-3">
        <a href="/admin/create" 
           class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded font-semibold shadow">
           + Tambah Konser
        </a>

        <a href="/admin/riwayat" 
           class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded font-semibold shadow">
           📊 Riwayat Pesanan
        </a>
    </div>

    <div class="bg-slate-800 rounded-xl overflow-hidden shadow">
        <table class="w-full text-left">
            <thead class="bg-slate-700">
                <tr>
                    <th class="p-3">Gambar</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Harga</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($konser as $k): ?>
                <tr class="border-b border-slate-700 hover:bg-slate-700">
                    
                    <!-- KOLOM GAMBAR (ANTI ERROR) -->
                    <td class="p-3">
                        <?php if(!empty($k['gambar'])): ?>
                            <img 
                                src="<?= base_url('uploads/gambar/' . $k['gambar']) ?>" 
                                alt="gambar konser"
                                class="w-20 h-20 object-cover rounded-lg border border-slate-600">
                        <?php else: ?>
                            <div class="w-20 h-20 bg-slate-600 rounded-lg flex items-center justify-center text-xs text-slate-300">
                                No Image
                            </div>
                        <?php endif; ?>
                    </td>

                    <td class="p-3 font-semibold"><?= esc($k['name_konser']) ?></td>
                    <td class="p-3"><?= esc($k['lokasi']) ?></td>
                    <td class="p-3"><?= esc($k['tanggal']) ?></td>
                    <td class="p-3">Rp <?= number_format($k['harga']) ?></td>
                    <td class="p-3"><?= esc($k['jumlah_bed']) ?></td>

                    <td class="p-3 space-x-2">
                        <a href="/admin/edit/<?= $k['id'] ?>" 
                           class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm">
                           Edit
                        </a>

                        <a href="/admin/delete/<?= $k['id'] ?>" 
                           onclick="return confirm('Yakin hapus konser ini?')"
                           class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                           Hapus
                        </a>
                    </td>

                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tambah Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<!-- NAVBAR GLOBAL (AUTO ADMIN / USER / GUEST) -->
<?= view('layout/navbar') ?>

<div class="max-w-xl mx-auto mt-16 bg-slate-800 p-8 rounded-xl shadow">

    <h2 class="text-2xl font-bold text-purple-400 mb-6">
        Tambah Konser
    </h2>

    <form action="/admin/store" method="post" enctype="multipart/form-data" class="space-y-4">


        <div>
            <label class="text-sm text-slate-300">Nama Konser</label>
            <input type="text" name="name_konser" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="text-sm text-slate-300">Lokasi</label>
            <input type="text" name="lokasi" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="text-sm text-slate-300">Tanggal</label>
            <input type="date" name="tanggal" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="text-sm text-slate-300">Harga</label>
            <input type="number" name="harga" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="text-sm text-slate-300">Jumlah Tiket</label>
            <input type="number" name="jumlah_bed" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="text-sm text-slate-300">Gambar Konser</label>
            <input type="file" name="gambar" accept="image/*" required
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>


        <div class="flex justify-between pt-4">
            <a href="/admin" 
               class="bg-slate-600 hover:bg-slate-700 px-4 py-2 rounded">
               ← Kembali ke Dashboard
            </a>

            <button 
                type="submit" 
                class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded font-semibold">
                Simpan Konser
            </button>
        </div>

    </form>
</div>

</body>
</html>

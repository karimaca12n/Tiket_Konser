<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit Konser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen">

<nav class="bg-slate-800 px-8 py-4 flex justify-between">
    <h1 class="text-xl font-bold text-purple-400">Admin Panel</h1>
    <div class="space-x-4">
        <a href="/admin" class="hover:text-purple-400">Dashboard</a>
        <a href="/admin/riwayat" class="hover:text-purple-400">Riwayat</a>
        <a href="/logout" class="text-red-400">Logout</a>
    </div>
</nav>

<div class="max-w-xl mx-auto mt-16 bg-slate-800 p-8 rounded-xl shadow">

    <h2 class="text-2xl font-bold text-purple-400 mb-6">
        Edit Konser
    </h2>

    <form action="/admin/update/<?= $konser['id'] ?>" method="post" class="space-y-4">

        <div>
            <label class="text-sm text-slate-300">Nama Konser</label>
            <input 
                type="text" 
                name="name_konser" 
                value="<?= $konser['name_konser'] ?>" 
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
        </div>

        <div>
            <label class="text-sm text-slate-300">Lokasi</label>
            <input 
                type="text" 
                name="lokasi" 
                value="<?= $konser['lokasi'] ?>" 
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
        </div>

        <div>
            <label class="text-sm text-slate-300">Tanggal</label>
            <input 
                type="date" 
                name="tanggal" 
                value="<?= $konser['tanggal'] ?>" 
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
        </div>

        <div>
            <label class="text-sm text-slate-300">Harga</label>
            <input 
                type="number" 
                name="harga" 
                value="<?= $konser['harga'] ?>" 
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
        </div>

        <div>
            <label class="text-sm text-slate-300">Jumlah Tiket</label>
            <input 
                type="number" 
                name="jumlah_bed" 
                value="<?= $konser['jumlah_bed'] ?>" 
                class="w-full mt-1 px-3 py-2 bg-slate-700 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
        </div>

        <div class="flex justify-between pt-4">
            <a href="/admin" 
               class="bg-slate-600 hover:bg-slate-700 px-4 py-2 rounded">
               ← Batal
            </a>

            <button 
                type="submit" 
                class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded font-semibold">
                Update Konser
            </button>
        </div>

    </form>
</div>

</body>
</html>

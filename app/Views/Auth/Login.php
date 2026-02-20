<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | SoraiFest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center">

<div class="w-full max-w-md">
    <div class="bg-slate-800 rounded-xl shadow-lg p-8">
        
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-purple-400">SoraiFest</h1>
            <p class="text-slate-400 text-sm">Login ke akun kamu</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="post" class="space-y-4">
            <div>
                <label class="text-sm">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 px-4 py-3 rounded bg-slate-900 border border-slate-700 focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="text-sm">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-3 rounded bg-slate-900 border border-slate-700 focus:outline-none focus:border-purple-500">
            </div>

            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded font-bold transition">
                Login
            </button>
        </form>

        <!-- REGISTER -->
        <p class="text-center text-sm text-slate-400 mt-6">
            Belum punya akun?
            <a href="/register" class="text-purple-400 hover:underline">
                Daftar di sini
            </a>
        </p>

        <!-- BACK TO KONSER (UNTUK GUEST) -->
        <a href="/konser"
           class="block text-center mt-4 bg-slate-700 hover:bg-slate-600 py-3 rounded font-semibold transition">
           ← Kembali ke Daftar Konser
        </a>

    </div>
</div>

</body>
</html>

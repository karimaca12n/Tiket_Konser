<nav class="bg-slate-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo / Brand -->
        <a href="/konser" class="text-2xl font-bold text-purple-400">
            SoraiFest
        </a>

        <div class="space-x-3 flex items-center">

            <!-- Menu umum (Guest & User bisa lihat konser) -->
            <a href="/konser" 
               class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
               Konser
            </a>

            <?php if (session()->get('logged_in')): ?>

                <!-- Jika role USER -->
                <?php if (session()->get('role') !== 'admin'): ?>
                    <a href="/pesanan-saya" 
                       class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded">
                       Riwayat Saya
                    </a>
                <?php endif; ?>

                <!-- Jika role ADMIN -->
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="/admin" 
                       class="bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded">
                       Dashboard Admin
                    </a>
                <?php endif; ?>

                <!-- Logout hanya muncul kalau login -->
                <a href="/logout" 
                   class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">
                   Logout
                </a>

            <?php else: ?>

                <!-- MODE GUEST (belum login) -->
                <a href="/login" 
                   class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded">
                   Login
                </a>

                <a href="/register" 
                   class="bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded">
                   Register
                </a>

            <?php endif; ?>

        </div>
    </div>
</nav>

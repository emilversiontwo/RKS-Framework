<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/output.css" rel="stylesheet">
    <title><?= htmlspecialchars($this->title ?? 'Приложение') ?></title>
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 font-sans">

<!-- Page wrapper: header + content + footer -->
<div class="flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Left: burger (mobile) + brand -->
                <div class="flex items-center space-x-4">
                    <!-- Sidebar toggle (mobile) -->
                    <button id="sidebarToggle" class="md:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Открыть меню">
                        <!-- simple burger icon -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <a href="/" class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">A</div>
                        <span class="hidden sm:inline-block font-semibold">RKS Framework</span>
                    </a>
                </div>

                <!-- Middle: search (collapses on very small screens) -->
                <div class="flex-1 px-4">
                    <div class="max-w-lg mx-auto">
                        <label class="sr-only" for="search">Поиск</label>
                        <div class="relative">
                            <input id="search" name="search" type="search" placeholder="Поиск..." class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3 bg-white" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: actions / profile -->
                <div class="flex items-center space-x-3">
                    <a href="/login" class="hidden md:inline-block text-sm px-3 py-2 rounded-md hover:bg-gray-100">Войти</a>
                    <a href="/register" class="hidden md:inline-block text-sm px-3 py-2 rounded-md hover:bg-gray-100">Регистрация</a>

                    <!-- Profile dropdown -->
                    <div class="relative">
                        <button id="profileBtn" class="flex items-center space-x-2 p-1 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <img src="https://plazadelduque.com/wp-content/uploads/2022/02/logo-rks.jpg" alt="Аватар" class="h-8 w-8 rounded-full object-cover" />
                            <span class="hidden sm:inline-block text-sm">Имя</span>
                            <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20 py-1" role="menu" aria-orientation="vertical" aria-labelledby="profileBtn">
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50" role="menuitem">Профиль</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50" role="menuitem">Настройки</a>
                            <form method="POST" action="/logout">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Выйти</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Body: optional sidebar + main content -->
    <div class="flex-1 flex overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="hidden md:block w-64 bg-white border-r border-gray-200 overflow-y-auto">
            <nav class="p-4 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-md hover:bg-gray-50">Главная</a>
                <a href="/projects" class="block px-3 py-2 rounded-md hover:bg-gray-50">Проекты</a>
                <a href="/docs" class="block px-3 py-2 rounded-md hover:bg-gray-50">Документация</a>
                <a href="/settings" class="block px-3 py-2 rounded-md hover:bg-gray-50">Настройки</a>
            </nav>
        </aside>

        <!-- Main content area -->
        <main class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <!-- Flash messages area (place for session flashes) -->
                <?php if (!empty($this->flash ?? null)): ?>
                    <div class="mb-4">
                        <?php foreach ($this->flash as $type => $messages): ?>
                            <?php foreach ((array)$messages as $msg): ?>
                                <div class="rounded-md p-3 mb-2 text-sm <?php echo $type === 'error' ? 'bg-red-50 text-red-800' : 'bg-green-50 text-green-800' ?>">
                                    <?= htmlspecialchars($msg) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Page title (optional) -->
                <?php if (!empty($this->pageTitle)): ?>
                    <h1 class="text-2xl font-semibold mb-4"><?= htmlspecialchars($this->pageTitle) ?></h1>
                <?php endif; ?>

                <!-- Here is the place for the page content -->
                <div id="pageContent" class="bg-white rounded-lg shadow-sm p-6">
                    <?= $this->content ?>
                </div>

            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm text-gray-600 flex items-center justify-between">
            <div>© <?= date('Y') ?> RKS Framework</div>
            <div class="space-x-4">
                <a href="/privacy" class="hover:underline">Политика</a>
                <a href="/terms" class="hover:underline">Условия</a>
            </div>
        </div>
    </footer>

</div>

<!-- Minimal JS for toggles (no framework dependency) -->
<script>
    // Sidebar toggle for mobile
    (function () {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        // mobile open: toggle hidden class on sidebar
        if (toggle) toggle.addEventListener('click', () => {
            if (!sidebar) return;
            sidebar.classList.toggle('hidden');
        });

        // profile dropdown toggle
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
            // close on outside click
            document.addEventListener('click', () => {
                if (!profileMenu.classList.contains('hidden')) profileMenu.classList.add('hidden');
            });
        }

        // preserve sidebar visibility on resize (if moving to md/desktop)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && sidebar) {
                sidebar.classList.remove('hidden');
            }
        });
    })();
</script>
</body>
</html>
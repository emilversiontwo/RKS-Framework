<?php
$this->title = 'Регистрация';
?>
<div class="max-w-md mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-semibold">Создать аккаунт</h2>
        <p class="text-sm text-gray-500">Уже есть аккаунт? <a href="/login" class="font-medium underline">Войти</a></p>
    </div>


    <form action="/register" method="POST" class="space-y-4 bg-white rounded-lg shadow-sm p-6">
        <?= $this->csrf ?? '' ?>

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Имя</label>
            <input id="name" name="name" type="text" required autocomplete="name" value="<?= htmlspecialchars($this->old['name'] ?? '') ?>" class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3" />
            <?php if (!empty($this->errors['name'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($this->errors['name']) ?></p>
            <?php endif; ?>
        </div>


        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input id="email" name="email" type="email" required autocomplete="email" value="<?= htmlspecialchars($this->old['email'] ?? '') ?>" class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3" />
            <?php if (!empty($this->errors['email'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($this->errors['email']) ?></p>
            <?php endif; ?>
        </div>


        <div>
            <label for="password" class="block text-sm font-medium mb-1">Пароль</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="new-password" class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3 pr-10" />
                <button type="button" class="absolute inset-y-0 right-0 pr-2 flex items-center" data-toggle="#password">Показать</button>
            </div>
            <?php if (!empty($this->errors['password'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($this->errors['password']) ?></p>
            <?php endif; ?>
        </div>


        <div>
            <label for="password_confirm" class="block text-sm font-medium mb-1">Подтвердите пароль</label>
            <input id="password_confirm" name="password_confirm" type="password" required autocomplete="new-password" class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3" />
        </div>


        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">Нажимая "Зарегистрироваться", вы принимаете <a href="/terms" class="underline">условия</a>.</div>
        </div>


        <div>
            <button type="submit" class="w-full inline-flex items-center justify-center py-2 px-4 rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Зарегистрироваться</button>
        </div>
    </form>
</div>


<script>
    (function(){
        document.querySelectorAll('button[data-toggle]').forEach(btn => {
            const selector = btn.getAttribute('data-toggle');
            const inp = document.querySelector(selector);
            if (!inp) return;
            btn.addEventListener('click', () => {
                if (inp.type === 'password') { inp.type = 'text'; btn.textContent = 'Скрыть'; }
                else { inp.type = 'password'; btn.textContent = 'Показать'; }
            });
        });
    })();
</script>
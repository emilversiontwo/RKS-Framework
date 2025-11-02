<?php
use Src\Core\View;
/** @var View $this */
$this->title = 'Вход';
?>


<div class="max-w-md mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-semibold">Войти в аккаунт</h2>
        <p class="text-sm text-gray-500">Нет аккаунта? <a href="/register" class="font-medium underline">Зарегистрироваться</a></p>
    </div>


    <form action="/login" method="POST" enctype="application/json" class="space-y-4 bg-white rounded-lg shadow-sm p-6">
        <?= $this->csrf ?? '' ?>


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
                <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3 pr-10" />
                <button type="button" class="absolute inset-y-0 right-0 pr-2 flex items-center" data-toggle="#password">Показать</button>
            </div>
            <?php if (!empty($this->errors['password'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($this->errors['password']) ?></p>
            <?php endif; ?>
        </div>


        <div class="flex items-center justify-between">
            <label class="flex items-center text-sm">
                <input type="checkbox" name="remember" class="mr-2" <?= !empty($this->old['remember']) ? 'checked' : '' ?> /> Запомнить
            </label>
            <a href="/forgot" class="text-sm underline">Забыли пароль?</a>
        </div>


        <div>
            <button type="submit" class="w-full inline-flex items-center justify-center py-2 px-4 rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Войти</button>
        </div>


        <!-- option: social logins -->
        <div class="pt-4">
            <div class="text-center text-sm text-gray-500 mb-3">Или войдите через</div>
            <div class="grid grid-cols-2 gap-3">
                <a href="/auth/google" class="inline-flex items-center justify-center py-2 px-3 rounded-md border border-gray-200">Google</a>
                <a href="/auth/github" class="inline-flex items-center justify-center py-2 px-3 rounded-md border border-gray-200">Github</a>
            </div>
        </div>
    </form>
</div>
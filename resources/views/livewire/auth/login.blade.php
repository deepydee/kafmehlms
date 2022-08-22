@section('title', 'Вход в ЛК')

<form wire:submit.prevent="login" class="space-y-6 w-full max-w-xs mx-auto">

    <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-indigo-600 focus-within:border-indigo-600">
        <label for="email" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Логин</label>
        <input wire:model.lazy='email' type="email" name="email" id="email" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="user@stud.spmi.ru">
    </div>
    @error('email') <div class="text-red-400 text-sm">{{ $message }}</div> @enderror

    <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-indigo-600 focus-within:border-indigo-600">
        <label for="password" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Пароль</label>
        <input wire:model.lazy='password' type="password" name="password" id="password" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
    </div>
    @error('password') <div class="text-red-400 text-sm">{{ $message }}</div> @enderror

    <div class="flex">
        <button type="submit"
            class="mx-auto px-6 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Вход</button>
    </div>
</form>
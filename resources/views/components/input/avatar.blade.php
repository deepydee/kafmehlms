<div class="flex items-center">
    {{ $slot }}
   
    <div x-data="{ focused: false }">
        <span>
            <input @focus="focused = true" @blur="focused = false" type="file" class="sr-only" {{ $attributes }}>
            <label for="{{ $attributes['id'] }}"
                class="cursor-pointer ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50"
                :class="{ 'outline-none ring-2 ring-offset-2 ring-indigo-500': focused }"
                >
                Изменить
            </label>
        </span>
    </div>
</div>
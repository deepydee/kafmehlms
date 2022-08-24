<x-slot name="head">Профиль</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    
  <form wire:submit.prevent='save' class="space-y-8 divide-y divide-gray-200">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div>
            <div>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Заполните информацию о себе</p>
            </div>

            <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                <x-input.group class="sm:border-t sm:pt-5" label="ФИО" for="username" :error="$errors->first('username')">
                    <x-input.text wire:model='user.username' name="username" id="username" autocomplete="username"/>
                </x-input.group>

                <x-input.group class="sm:border-t sm:pt-5" label="Аватар" for="photo" :error="$errors->first('upload')">
                    <x-input.avatar wire:model='upload' id="photo">
                        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            @if ($upload)
                                <img src="{{ $upload->temporaryUrl() }}" alt="Profile photo">
                            @else
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="Profile photo">
                            @endif
                        </span>
                    </x-input.avatar>
                </x-input.group>


            </div>

            <div class="pt-5">
              <div class="flex justify-end items-center space-x-3">
                  <span
                  x-data="{ open: false }"
                  x-init="
                     @this.on('notify-saved', () => {
                          open = true;
                          setTimeout(() => {open = false}, 2500);
                      });
                  "
                  x-show="open"
                  x-transition:leave.duration.1000ms
                  x-cloak
                  class="text-gray-500"
                  >Изменения сохранены!</span>
                   <a href="{{route('logout')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Выйти</a>
                  <button type="submit"
                      class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Сохранить</button>
              </div>
          </div>

</form>
    
</div>
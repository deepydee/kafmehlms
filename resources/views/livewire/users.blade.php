<x-slot name="head">Пользователи</x-slot>
<div class="bg-white py-10">
  <div class="mx-auto max-w-7xl">
    <div class="px-4 sm:px-6 lg:px-8">

      <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">Пользователи</h1>
          <p class="mt-2 text-sm text-gray-700">Список всех пользователей</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <button wire:click='create' type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Добавить</button>
        </div>
      </div>
        
     
        <x-table>
          <x-slot name="head">
            <x-table.heading>
              <x-input.checkbox wire:model='selectPage'/>
            </x-table.heading>
            <x-table.heading class="sm:pl-6 md:pl-0">ФИО</x-table.heading>
            <x-table.heading>email</x-table.heading>
            <x-table.heading>Роль</x-table.heading>
            <x-table.heading>Последний визит</x-table.heading>
          </x-slot>

          <x-slot name="body">
            @forelse ($users as $user)
            <x-table.row wire:loading.class.delay='opacity-50' wire:key='row-{{ $user->id }}'>
                <x-table.cell>
                    <x-input.checkbox wire:model='selected' value="{{ $user->id }}" />
                </x-table.cell>

                <x-table.cell class="flex items-center whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                  <div class="h-10 w-10 flex-shrink-0">
                    <img class="inline-block h-10 w-10 rounded-full" src="{{ $user->avatarUrl() }}">
                  </div>
                  <div class="ml-4">{{ $user->username }}</div>
                </x-table.cell>

                <x-table.cell>
                    {{ $user->email }}
                </x-table.cell>

                <x-table.cell>
                  {{ \App\Models\USER::ROLES[$user->user_role] }}
                </x-table.cell>
                <x-table.cell>
                    {{ $user->getRuPostDate() }}
                </x-table.cell>

                <x-table.cell>
                    <x-button.link wire:click='edit({{ $user->id }})'>Редактировать</x-button.link>
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.row>
                <x-table.cell colspan="6">
                    <div class="flex justify-center items-center space-x-2">
                        <x-icon.inbox class="h-8 inline-block text-gray-300 w-8"/>
                        <span class='font-medium py-8 text-gray-400 text-lg'>Пользователей нет...</span>
                    </div>
                </x-table.cell>
            </x-table.row>
        @endforelse
          </x-slot>

        </x-table>

    </div>
  </div>

      <!-- Save Transaction Modal -->
      <form wire:submit.prevent='save'>
        <x-modal.dialog wire:model='showEditModal'>
            <x-slot name="title">Редактировать</x-slot>
        
            <x-slot name="content">
                <div class="space-y-4">
                    <x-input.group for="username" label="ФИО" :error="$errors->first('editing.username')">
                        <x-input.text wire:model='editing.username' id="username" placeholder="ФИО" />
                    </x-input.group>

                    <x-input.group for="email" label="Логин (email)" :error="$errors->first('editing.email')">
                        <x-input.text wire:model='editing.email' type="email" placeholder="user@stud.spmi.ru" id="email" />
                    </x-input.group>

                    <x-input.group for="password" label="Пароль" :error="$errors->first('editing.password')">
                        <x-input.text wire:model='editing.password' type="password" id="password" />
                    </x-input.group>

                    <x-input.group for="user_role" label="Роль" :error="$errors->first('editing.user_role')">
                        <x-input.select wire:model='editing.user_role' id="user_role">
                            @foreach (App\Models\User::ROLES as $value => $label)
                                <option value="{{$value}}">{{$label}}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="avatar" label="Аватар" :error="$errors->first('editing.avatar')" class="flex items-center">
                      @if ($editing->avatar)
                        <div class="h-10 w-10 flex-shrink-0">
                          <img class="h-10 w-10 rounded-full" src="{{ $editing->avatar->temporaryUrl() }}" alt="">
                        </div>
                      @else
                        <div class="h-10 w-10 flex-shrink-0">
                          <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatarUrl() }}" alt="">
                        </div>
                      @endif
                     
                      <x-input.file-upload wire:model='editing.avatar' id="avatar" />
                      
                    </x-input.group>

                </div>
            </x-slot>
        
            <x-slot name="footer">
                <div class="space-x-1">
                    <x-button.secondary>Отмена</x-button.secondary>
                    <x-button.primary type='submit'>Сохранить</x-button.primary>
                </div>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
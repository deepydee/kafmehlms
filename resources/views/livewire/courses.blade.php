<x-slot name="head">Курсы</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    
    <!-- Replace with your content -->
    <div class="py-4">

        <x-button.link wire:click='create' class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Добавить</x-button.link>

        <div class="py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

  <div class="rounded-lg overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
    
    @forelse ($courses as $course)

        <x-card.shared-border>
            <x-slot name="head">
                {{ \App\Models\Course::COURSES[$course->title] }}
            </x-slot>
            <x-slot name="image">
                <img class="h-40" src="{{ $course->getThumbUrl() }}" alt="">
            </x-slot>
            <x-slot name="date">
                {{ $course->start_date }}
            </x-slot>
           {{ $course->description }}

            <x-button.link wire:click='edit({{ $course->id }})'>Редактировать</x-button.link>
        </x-card.shared-border>
        
    @empty
        <div>
            Empty...
        </div>
    @endforelse

   
  </div>

  

    </div>
  </div>
      
  

    </div>
    <!-- /End replace -->

          <!-- Save Transaction Modal -->
          <form wire:submit.prevent='save'>
            <x-modal.dialog wire:model='showEditModal'>
                <x-slot name="title">Создать/Редактировать курс</x-slot>
            
                <x-slot name="content">
                    <div class="space-y-4">
                        <x-input.group for="title" label="Предмет" :error="$errors->first('editing.title')">
                            <x-input.select wire:model='editing.title' id="title">
                                @foreach (App\Models\Course::COURSES as $value => $label)
                                    <option value="{{$value}}">{{$label}}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group for="description" label="Описание курса" :error="$errors->first('editing.description')">
                            <x-input.textarea wire:model='editing.description' id="description"/>
                        </x-input.group>
                        
                        <x-input.group class="sm:border-t sm:pt-5" label="Начало курса" for="start_date" :error="$errors->first('editing.start_date')">
                            <x-input.text wire:model='editing.start_date' name="start_date" id="start_date" placeholder="MM/DD/YYYY"/>
                        </x-input.group>
    
                        <x-input.group for="course_image" label="Обложка" :error="$errors->first('editing.course_image')" class="flex items-center">
                          @if ($upload)
                            <div class="h-10 w-10 flex-shrink-0">
                              <img class="h-10 w-10 rounded-full" src="{{ $upload->temporaryUrl() }}" alt="">
                            </div>
                          @else
                            <div class="h-10 w-10 flex-shrink-0">
                              <img class="h-10 w-10 rounded-full" src="#" alt="">
                            </div>
                          @endif
                         
                          <x-input.file-upload wire:model='upload' id="course_image" :error="$errors->first('upload')"/>
                          
                        </x-input.group>
    
                    </div>
                </x-slot>
            
                <x-slot name="footer">
                    <div class="space-x-1">
                        <x-button.secondary wire:click='cancel'>Отмена</x-button.secondary>
                        <x-button.primary type='submit'>Сохранить</x-button.primary>
                    </div>
                </x-slot>
            </x-modal.dialog>
        </form>
</div>

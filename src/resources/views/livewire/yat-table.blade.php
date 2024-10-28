<section>
    <div class="p-2" x-data="{showFilters: false}">
        @if($customHeader)
        {!! $customHeader !!}
        @endif
        @if($title)
        <div class="{{($titleClasses ?? 'text-3xl font-thin text-gray-600 dark:text-gray-300 mb-4')}}">{{$title}}</div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <!-- Search Input && Filters -->
            <div class="flex w-full space-x-3">
                @if($has_filters)
                <button @click="showFilters = ! showFilters" class="border focus:border-2 dark:focus:border border-gray-200 dark:border-secondary-700 text-gray-600 dark:text-gray-400 outline-none inline-flex justify-center items-center group hover:shadow-sm dark:bg-secondary-700 hover:text-gray-700  dark:hover:bg-secondary-600 focus:text-gray-700 focus:border-gray-500 focus:ring-gray-500 dark:focus:bg-secondary-600 dark:focus:ring-secondary-600 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
                    {{ucfirst(__('yat::yat.filters'))}}
                    @if(!$show_filters)
                        <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 totate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    @else
                        <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 rotate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 15.75l-7.5-7.5-7.5 7.5"/>
                        </svg>
                    @endif
                </button>
                @endif
                <div class="relative">
                    <input 
                        wire:model.live="search" 
                        placeholder="{{ ucfirst(__('yat::yat.search')) }}..." 
                        type="text" 
                        class="min-w-96 py-2 pr-10 pl-3 block w-full border-gray-200 rounded-lg text-sm focus:border-gray-600 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none dark:bg-secondary-700 dark:border-secondary-700 dark:text-secondary-300 dark:placeholder-secondary-500 dark:focus:ring-secondary-600" 
                        autocomplete="off"
                    />
                
                    <button 
                        type="button" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                        x-show="!!$wire.get('search')" 
                        @click="$wire.set('search', '');"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                @if($options)
                <!-- Options Button -->
                <div x-data="{ isOpenOptionsToggle: false}" class="relative" @keydown.esc.window="isOpenOptionsToggle = false">
                    <!-- Toggle Button -->
                    <button @click="isOpenOptionsToggle = ! isOpenOptionsToggle" class="border focus:border-2 dark:focus:border border-gray-200 dark:border-secondary-700 text-gray-600 dark:text-gray-400 outline-none inline-flex justify-center items-center group hover:shadow-sm dark:bg-secondary-700 hover:text-gray-700  dark:hover:bg-secondary-600 focus:text-gray-700 focus:border-gray-500 focus:ring-gray-500 dark:focus:bg-secondary-600 dark:focus:ring-secondary-600 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
                        {{ucfirst(__('yat::yat.options'))}}
                        <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 totate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-cloak x-show="isOpenOptionsToggle" x-transition @click.outside="isOpenOptionsToggle = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="z-30 absolute top-11 right-0 inline-block rounded-md whitespace-nowrap" role="menu">
                        <ul class="rounded-md text-sm font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($options as $function => $label)
                            <li class="w-full border-b last:border-b-0 border-gray-200 hover:bg-gray-200 rounded-mc dark:border-gray-600 dark:hover:bg-gray-600">
                                <div class="flex items-center ps-3 pr-3">
                                    <div 
                                        wire:click="{{$function}}" 
                                        class="cursor-pointer w-full pr-3 py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 flex items-center" 
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50"
                                    >
                                        <span>{!! $label !!}</span>

                                        <!-- Spinner next to the text when loading -->
                                        <span wire:loading wire:target="{{$function}}" class="ml-2 flex items-center"> 
                                            <svg class="w-4 h-4 text-gray-900 dark:text-gray-300 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 100 8v4a8 8 0 01-8-8z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach       
                        </ul>                 
                    </div>
                </div>
                @endif

                <!-- Columns Button -->
                <div x-data="{ isOpenColumnToggle: false}" class="relative " @keydown.esc.window="isOpenColumnToggle = false">
                    <!-- Toggle Button -->
                    <button @click="isOpenColumnToggle = ! isOpenColumnToggle" class="border focus:border-2 dark:focus:border border-gray-200 dark:border-secondary-700 text-gray-600 dark:text-gray-400 outline-none inline-flex justify-center items-center group hover:shadow-sm dark:bg-secondary-700 hover:text-gray-700  dark:hover:bg-secondary-600 focus:text-gray-700 focus:border-gray-500 focus:ring-gray-500 dark:focus:bg-secondary-600 dark:focus:ring-secondary-600 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
                        {{ucfirst(__('yat::yat.columns'))}}
                        <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 totate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-cloak x-show="isOpenColumnToggle" x-transition @click.outside="isOpenColumnToggle = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="z-30 absolute top-11 right-0 inline-block rounded-md whitespace-nowrap" role="menu">
                        <ul class="rounded-md text-sm font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @if($handle_state)
                            <li class="w-full border-b last:border-b-0 border-gray-200 rounded-t-lg rounded-mc dark:border-gray-600">
                                <div class="p-3">
                                    <button 
                                        wire:click="saveTableState" 
                                        type="button" 
                                        class="w-full px-2 py-2 text-xs font-medium text-center text-white bg-secondary-400 rounded-lg hover:bg-secondary-500 focus:outline-none dark:bg-secondary-600 dark:hover:bg-secondary-500 dark:focus:ring-secondary-700 relative"
                                        wire:loading.attr="disabled"
                                    >   

                                        <span wire:loading.remove>{{ucfirst(__('yat::yat.save_column_election'))}}</span>
                                        <span wire:loading class="ml-2">{{ucfirst(__('yat::yat.saving'))}}...</span>
                                        <!-- Spinner next to the text when loading -->
                                        <span wire:loading wire:target="saveTableState" class="flex items-center justify-center">
                                            <svg class="w-2 h-2 mr-2 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 100 8v4a8 8 0 01-8-8z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </li>
                            @endif
                        @foreach ($columns as $key => $column)
                            @if(!$column->hideFromSelector)
                                <li class="w-full border-b last:border-b-0 border-gray-200 hover:bg-gray-200  rounded-mc dark:border-gray-600 dark:hover:bg-gray-700">
                                    <div class="flex items-center ps-3">
                                        <input id="{{ $column->key }}" type="checkbox" wire:model.live="columns.{{ $key }}.isVisible" class="cursor-pointer w-4 h-4 text-gray-500 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="{{ $column->key }}" class="cursor-pointer pr-3  w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $column->label }}</label>
                                    </div>
                                </li>
                            @endif
                        @endforeach       
                        </ul>                 
                    </div>
                </div>
                <div class="relative">
                    <select wire:model.live="perPage" class="min-w-20 w-full border-gray-200 rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-secondary-700 dark:border-secondary-700 dark:text-secondary-400 dark:placeholder-secondary-500 dark:focus:ring-secondary-600">
                        @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>  
                </div>
            </div>
        </div>


        <!-- Filters -->
        @if($has_filters)
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <div x-show="showFilters" x-transition class="flex space-x-3 mb-3">
            @foreach ($filters as $key => $filter)
                @if($filter->type == "string")
                    <div class="relative">
                        <input 
                            wire:model.live.debounce.200ms="filters.{{$key}}.input" 
                            placeholder="{{$filter->label}}" 
                            class="max-w-48 min-w-48 py-2 pr-10 pl-3 block w-full border-gray-200 rounded-lg text-sm focus:border-gray-600 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none dark:bg-secondary-700 dark:border-secondary-700 dark:text-secondary-300 dark:placeholder-secondary-500 dark:focus:ring-secondary-600" 
                            autocomplete="off"
                        />
                    
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                            x-show="!!$wire.get('filters.{{$key}}.input')"
                            @click="$wire.set('filters.{{$key}}.input', '');"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
                @if($filter->type == "daterange")
                    <div class="relative">
                        <input 
                            type="text" 
                            id="filters-{{$filter->key}}" 
                            class="min-w-56 max-w-56 py-2 pr-8 pl-3 block w-full border-gray-200 rounded-lg text-sm focus:border-gray-600 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none dark:bg-secondary-700 dark:border-secondary-700 dark:text-secondary-300 dark:placeholder-secondary-500 dark:focus:ring-secondary-600" 
                            placeholder="{{$filter->label}}"
                            wire:model.change="filters.{{$key}}.input"
                            autocomplete="off"
                        />
                    
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                            x-show="!!$wire.get('filters.{{$key}}.input')"  
                            @click="$wire.set('filters.{{$key}}.input', '');" 
                            style="display: none;" 
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            flatpickr("#filters-{{$filter->key}}", {
                                mode: "range",
                                dateFormat: "Y-m-d"
                            });
                        });
                    </script>
                @endif
            @endforeach
        </div>
        @endif
  
        <!-- Data Table -->
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full border-collapse block md:table border border-gray-200 dark:border-gray-700">
                <thead class="hidden md:table-header-group bg-gray-50 dark:bg-gray-800">
                    <tr class="border-b md:border-none bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                        @if ($has_bulk)
                            <th class="text-left px-5">
                                <input type="checkbox" wire:model.live="selectAll" class="cursor-pointer border-2 text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            </th>
                        @endif
                        @foreach ($columns as $column)
                            @if (!$column->isHidden && $column->isVisible)
                                <th wire:click="sortBy('{{ $column->key }}')" class="px-5 py-3 cursor-pointer text-xs font-medium whitespace-nowrap uppercase tracking-wider text-gray-500 dark:bg-gray-800 dark:text-gray-400" >
                                    <div class="{{ (property_exists($column, 'isBool') && $column->isBool) ? 'text-center' : 'text-left' }}">
                                        <span class="">{{ $column->label }}</span>
                                        <span class="text-xs">
                                            @if ($sortColumn === $column->key)
                                                @if ($sortDirection === 'asc')
                                                    &#8593;
                                                @else
                                                    &#8595;
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                </th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody class="block md:table-row-group">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-600 border-b md:border-none transition-colors odd:bg-white even:bg-gray-50 dark:odd:bg-gray-700 dark:even:bg-gray-800">
                            @if ($has_bulk)
                                <td class="px-5">
                                    <input value="{{ $row[$column_id] }}"  type="checkbox" wire:model.live="selected" class="cursor-pointer  text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                </td>
                            @endif
                            @foreach ($columns as $column)
                              @if (!$column->isHidden && $column->isVisible)
                                    @if(property_exists($column, 'isBool') && $column->isBool)
                                    <td class="text-center {{$column->classes}}">
                                        {{ ($row[$column->key]) ? '✔️' : '❌' }}
                                    </td>
                                    @elseif(property_exists($column, 'isHtml') && $column->isHtml)
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}} ">
                                        {!! $row[$column->key] ?? '' !!}
                                    </td>
                                    @elseif(property_exists($column, 'isLink') && $column->isLink)
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}} ">
                                        <a href="{{$column->parsed_href}}" class="{{$column->tag_classes ?? ''}}">{{ $column->text }}</a>
                                    </td>
                                    @else
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}}">
                                        {{ $row[$column->key] ?? '' }}
                                    </td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" class="">
                                <div class="text-xl p-3 text-gray-700 dark:text-gray-300">No hay resultados para <i>{{$search}}</i></div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
  
        <!-- Pagination -->
        <div class="mt-4">
            {{ $rows->links() }}
        </div>
    </div>
  </section>
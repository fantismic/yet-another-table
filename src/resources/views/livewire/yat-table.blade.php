<section>
    <div classes="{{$main_wrapper_classes}}" x-data="{showFilters: false}">
        @if($customHeader) {!! $customHeader !!} @endif
        @if($title) <div class="{{($titleClasses ?? 'text-3xl font-thin text-gray-600 dark:text-gray-300 mb-4')}}">{{$title}}</div> @endif
        
        <div class="flex justify-between items-center mb-4">
            <!-- Search Input && Filters -->
            <div class="flex w-full space-x-3">
                @if($has_filters)
                <button @click="showFilters = ! showFilters" class="outline-none inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed bg-opacity-60 dark:bg-opacity-30 text-secondary-600 bg-secondary-300 dark:bg-secondary-600 dark:text-secondary-400 hover:bg-opacity-60 dark:hover:bg-opacity-30 hover:text-secondary-800 hover:bg-secondary-400 dark:hover:text-secondary-400 dark:hover:bg-secondary-500 focus:bg-opacity-60 dark:focus:bg-opacity-30 focus:ring-offset-2 focus:text-secondary-800 focus:bg-secondary-400 focus:ring-secondary-400 dark:focus:text-secondary-400 dark:focus:bg-secondary-500 dark:focus:ring-secondary-700 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
                    {{ucfirst(__('yat::yat.filters'))}}
                    <div>
                        <svg 
                            aria-hidden="true" 
                            fill="none" 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24" 
                            stroke-width="2" 
                            stroke="currentColor" 
                            class="w-4 h-4 transition-transform duration-300" 
                            :class="!showFilters ? 'rotate-180' : 'rotate-0'"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                d="M19.5 15.75l-7.5-7.5-7.5 7.5"
                            />
                        </svg>
                    </div>
                </button>
                @endif
                @include('YATPackage::livewire.parts.global-search')
            </div>
            
            <div class="flex items-center space-x-2">
                @includeWhen($options, 'YATPackage::livewire.parts.options')
                @includeWhen($show_column_toggle, 'YATPackage::livewire.parts.column-toggle')
                @includeWhen($with_pagination, 'YATPackage::livewire.parts.select-perpage')
            </div>
        </div>


        <!-- Filters -->
        @includeWhen($has_filters, 'YATPackage::livewire.parts.filters')
  
        <!-- Data Table -->
        <div class="{{ $override_table_classes ? $table_classes : $table_classes. 'overflow-x-auto rounded-lg'}}" >
            <table class="min-w-full border-collapse block md:table border border-gray-200 dark:border-gray-700">
                <thead class="hidden md:table-header-group bg-gray-50 dark:bg-gray-800 {{ $sticky_header ? 'sticky -top-[0.125rem]' : '' }}">
                    <tr class="border-b md:border-none bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                        @if ($has_bulk)
                            <th class="text-left px-5">
                                <input type="checkbox" wire:model.live="selectAll" class="cursor-pointer border-2 text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            </th>
                        @endif
                        @foreach ($columns as $column)
                            @if (!$column->isHidden && $column->isVisible)
                                <th wire:click="sortBy('{{ $column->key }}')" class="px-5 py-3 cursor-pointer text-xs font-medium whitespace-nowrap uppercase tracking-wider text-gray-500 dark:bg-gray-800 dark:text-gray-400 {{$column->th_classes}}" >
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
                    @if($selectAll && $filtered_data_count != $all_data_count)
                    <tr >
                        <td colspan="{{ $cols = ($has_bulk) ? count($columns) + 1 : count($columns) }}">
                            <div class="px-5 py-3 whitespace-nowrap text-pretty text-base font-normal text-gray-700 dark:text-gray-300">                                
                                {!! ucfirst(__('yat::yat.select_filter_warning',['filtered_count' => $filtered_data_count, 'all_data_count' => $all_data_count])) !!} <span class="cursor-pointer font-bold underline" wire:click="clearAllFilters">{{__('yat::yat.remove_all_filters')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @if($loading_table_spinner)
                    <tr 
                        class="hidden d-none bg-red" 
                        @if($loading_table_spinner) 
                            wire:loading.long.class.remove="hidden d-none"
                            wire:target="{{$trigger_spinner}}"
                        @endif
                        
                    >
                        <td colspan="{{ $cols = ($has_bulk) ? count($columns) + 1 : count($columns) }}">
                            @includeUnless($loading_table_spinner_custom_view, 'YATPackage::livewire.parts.loading-table')
                            @includeWhen($loading_table_spinner_custom_view, $loading_table_spinner_custom_view)
                        </td>
                    </tr>
                    @endif
                    @forelse ($rows as $key => $row)
                        <tr
                            class="hover:bg-gray-100 dark:hover:bg-gray-600 border-b md:border-none transition-colors even:bg-white odd:bg-gray-50 dark:even:bg-gray-700 dark:odd:bg-gray-800"
                            @if($loading_table_spinner) 
                                wire:loading.long.class.add="hidden d-none"
                                wire:target="{{$trigger_spinner}}"
                            @endif
                        >
                            @if ($has_bulk)
                                <td class="px-5">
                                    <input value="{{ $row[$column_id] }}"  type="checkbox" wire:model.live="selected" class="cursor-pointer  text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                </td>
                            @endif
                            @foreach ($columns as $column)
                              @if (!$column->isHidden && $column->isVisible)
                                    @if(property_exists($column, 'hasView') && $column->hasView)
                                    <td>
                                        @include($column->view)
                                    </td>
                                    @elseif(property_exists($column, 'isBool') && $column->isBool)
                                    <td class="text-center {{$column->classes}}">
                                        @if($row[$column->key])
                                            {!! $column->true_icon !!}
                                        @else
                                            {!! $column->false_icon !!}
                                        @endif
                                    </td>
                                    @elseif(property_exists($column, 'isHtml') && $column->isHtml)
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}} ">
                                        {!! $row[$column->key] ?? '' !!}
                                    </td>
                                    @elseif(property_exists($column, 'isLink') && $column->isLink)
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}} ">
                                        <a href="{{$column->parsed_href[$key]}}" class="{{$column->tag_classes ?? ''}}">{{ $column->text ?? $row[$column->key] }}</a>
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
                        <tr
                            @if($loading_table_spinner) 
                                wire:loading.long.class.add="hidden d-none"
                                wire:target="{{$trigger_spinner}}"
                            @endif
                        >
                            <td colspan="{{ $cols = ($has_bulk) ? count($columns) + 1 : count($columns) }}" class="text-center py-5">
                                <div class="text-xl p-3 text-gray-700 dark:text-gray-300">{{ucfirst(__('yat::yat.empty_search'))}}</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
  
        <!-- Pagination -->
        @includeWhen($with_pagination, 'YATPackage::livewire.parts.pagination')
    </div>

    @includeWhen($modals_view,$modals_view)
  </section>
<section>
    <div class="{{$main_wrapper_classes}}" x-data="{showFilters: false}">
        @if($customHeader) {!! $customHeader !!} @endif
        @if($title) <div class="{{($titleClasses ?? 'text-3xl font-thin text-gray-600 dark:text-gray-300 mb-4')}}">{{$title}}</div> @endif
        
        <div class="flex flex-col sm:flex-row sm:justify-between items-center mb-4 space-y-2 sm:space-y-0">
            <!-- Search Input && Filters -->
            <div class="flex flex-col md:flex-row items-center space-x-2 space-y-2">
                <div class="flex flex-col md:w-auto w-full">
                    @includeWhen($yat_most_left_view, $yat_most_left_view)
                </div>
                <div class="flex flex-col md:w-auto w-full">
                    @if($has_filters)
                    <button @click="showFilters = ! showFilters" class="hidden outline-none sm:inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed bg-opacity-60 dark:bg-opacity-30 text-secondary-600 bg-secondary-300 dark:bg-secondary-600 dark:text-secondary-400 hover:bg-opacity-60 dark:hover:bg-opacity-30 hover:text-secondary-800 hover:bg-secondary-400 dark:hover:text-secondary-400 dark:hover:bg-secondary-500 focus:bg-opacity-60 dark:focus:bg-opacity-30 focus:ring-offset-2 focus:text-secondary-800 focus:bg-secondary-400 focus:ring-secondary-400 dark:focus:text-secondary-400 dark:focus:bg-secondary-500 dark:focus:ring-secondary-700 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
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
                </div>
                @if(!$yat_is_mobile)
                    <div class="flex flex-col md:w-auto w-full">
                        @include('YATPackage::livewire.parts.global-search')
                    </div>
                @endif
                <div class="flex flex-col md:w-auto w-full">
                    @includeWhen($yat_less_left_view, $yat_less_left_view)
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center space-x-2 space-y-2">
                <!-- These should stack as columns on mobile -->
                <div class="flex flex-col md:w-auto w-full">
                    @includeWhen($yat_less_right_view, $yat_less_right_view)
                </div>
                <div class="flex flex-col md:w-auto w-ful">
                    @includeWhen($yat_custom_buttons, 'YATPackage::livewire.parts.custom-buttons')
                </div>
            
                <!-- These should always remain in a row (even on mobile) -->
                <div class="flex md:flex-row w-full md:w-auto space-x-2">
                    @includeWhen($options, 'YATPackage::livewire.parts.options')
                    @includeWhen($show_column_toggle, 'YATPackage::livewire.parts.column-toggle')
                    @includeWhen($with_pagination, 'YATPackage::livewire.parts.select-perpage')
                </div>
            
                <!-- These should stack as columns on mobile -->
                <div class="flex flex-col md:w-auto w-full">
                    @includeWhen($yat_most_right_view, $yat_most_right_view)
                </div>
            </div>
            @if($yat_is_mobile)
                <div class="flex flex-col md:w-auto w-full">
                    @include('YATPackage::livewire.parts.global-search')
                </div>
            @endif
            
        </div>


        <!-- Filters -->
        @includeWhen($has_filters, 'YATPackage::livewire.parts.filters')
  
        <!-- Data Table -->
        <div class="{{ $override_table_classes ? $table_classes : $table_classes. 'w-full overflow-x-auto rounded-lg'}}" >
            <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                <thead class="min-w-full bg-gray-50 dark:bg-gray-800 {{ $sticky_header ? 'sticky -top-[0.125rem]' : '' }}">
                    <tr class="border-b md:border-none bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                        @if($has_counter)
                                <td class="pl-2">#</td>
                            @endif
                        @if ($has_bulk)
                            <th class="text-left px-5">
                                <input type="checkbox" wire:model.live="selectAll" class="cursor-pointer border-2 text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            </th>
                        @endif
                        @foreach ($columns as $column)
                            @if (!$column->isHidden && $column->isVisible)
                                <th wire:click="sortBy('{{ $column->key }}')" class="px-5 py-3 cursor-pointer text-xs font-medium whitespace-nowrap uppercase tracking-wider text-gray-500 dark:bg-gray-900 dark:text-gray-400 {{$column->th_classes}}" >
                                    <div class="{{ (property_exists($column, 'isBool') && $column->isBool) ? 'text-center' : 'text-left' }} {{ (property_exists($column, 'th_wrapper_classes')) ? $column->th_wrapper_classes : '' }}">
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

                <tbody class="min-w-full">
                    @if($selectAll && $all_data_count != count($rows))
                    <tr >
                        <td colspan="{{ $cols = ($has_bulk) ? count($columns) + 1 : count($columns) }}">
                            <div class="px-5 py-3 whitespace-nowrap text-pretty text-base font-normal text-gray-700 dark:text-gray-300">
                                @if($filtered_data_count && $filtered_data_count != $all_data_count)
                                    {!! ucfirst(__('yat::yat.select_filter_warning',['filtered_count' => $filtered_data_count, 'all_data_count' => $all_data_count])) !!} <span class="cursor-pointer font-bold underline" wire:click="clearAllFilters(true)">{{__('yat::yat.remove_all_filters')}}</span>
                                @else
                                    @if($pageSelected)
                                        Se seleccionaron {{ count($yat_selected_checkbox) }} de {{ $all_data_count }} registros (página actual). Haga <span class="cursor-pointer font-bold underline" wire:click="select_all_data(true)">click aquí</span> para seleccionar todos los registros.
                                    @else
                                        Se seleccionaron todos los registros. Haga <span class="cursor-pointer font-bold underline" wire:click="selectCurrentPage(true)">click aquí</span> para seleccionar la página actual.
                                    @endif
                                @endif
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
                            class="hover:bg-gray-200 dark:hover:bg-gray-700 border-b md:border-none transition-colors even:bg-white odd:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 "
                            @if($loading_table_spinner) 
                                wire:loading.long.class.add="hidden d-none"
                                wire:target="{{$trigger_spinner}}"
                            @endif
                        >
                            @if($has_counter)
                                <td class="pl-2 text-sm text-gray-600 dark:text-gray-300 font-extralight">{{ $loop->iteration }}</td>
                            @endif
                            @if ($has_bulk)
                                <td class="px-5">
{{--                                     @if(in_array($row[$column_id], $yat_selected_checkbox))
                                        <input value="{{ $row[$column_id] }}" id="{{ $row[$column_id] }}" type="checkbox" wire:change="changeYatSelectedCheckbox('{{$row[$column_id]}}')" class="cursor-pointer  text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" checked>
                                    @else
                                        <input value="{{ $row[$column_id] }}" id="{{ $row[$column_id] }}" type="checkbox" wire:change="changeYatSelectedCheckbox('{{$row[$column_id]}}')" class="cursor-pointer  text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif --}}
                                    <input 
                                    type="checkbox" 
                                    value="{{ $row[$column_id] }}" 
                                    id="{{ $row[$column_id] }}" 
                                    wire:model="yat_selected_checkbox" 
                                    class="cursor-pointer text-gray-500 bg-gray-100 border-gray-400 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                
                                </td>
                            @endif
                            @foreach ($columns as $column)
                              @if (!$column->isHidden && $column->isVisible)
                                    @if(property_exists($column, 'hasView') && $column->hasView)
                                    <td class="">
                                        @include($column->view)
                                    </td>
                                    @elseif(property_exists($column, 'isBool') && $column->isBool)
                                    <td class="text-center {{$column->classes}} ">
                                        @if($row[$column->key] === true || strtolower($row[$column->key]) == "true" || strtolower($row[$column->key]) == "1" || strtolower($row[$column->key]) === 1)
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
                                    @php
                                        $link_data = json_decode($row[$column->key],true);
                                    @endphp
                                    <a href="{{$link_data[0]}}" class="{{$column->tag_classes ?? 'cursor-pointer'}}">{!! $link_data[1] !!}</a>
                                    </td>
                                    @else
                                    <td class="px-5 py-3 whitespace-nowrap text-pretty text-sm font-normal text-gray-700 dark:text-gray-300 {{$column->classes}} ">
                                        {{ $row[$column->key] ?? '' }}
                                    </td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        @if (isset($row[$column_id]) && in_array($row[$column_id], $yatable_expanded_rows))
                            <tr>
                                <td colspan="{{ $cols = ($has_bulk) ? count($columns) + 1 : count($columns) }}" class="p-1">
                                    @if($yatable_expanded_rows_is_component)
                                        @livewire($yatable_expanded_rows_content[$row[$column_id]]['component'], $yatable_expanded_rows_content[$row[$column_id]]['parameters'], key('yatable_expanded_rows_content'.$row[$column_id]))
                                    @else
                                        {!! $yatable_expanded_rows_content[$row[$column_id]] !!}
                                    @endif
                                </td>
                            </tr>
                        @endif
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

    <!-- PopUp -->
    @foreach ($columns as $column)
        @if(property_exists($column, 'isLink') && $column->isLink && property_exists($column, 'popup'))
            <script>
                function openPopup{{$column->key}}(url) {
                    const width = {{ $column->popup["width"] }};
                    const height = {{ $column->popup["height"] }};
                    const left = (screen.width - width) / 2;
                    const top = (screen.height - height) / 2;
            
                    window.open(
                        url,
                        '',
                        `width=${width},height=${height},top=${top},left=${left},resizable,scrollbars`
                    );
                }
            </script>
        @endif
    @endforeach
  </section>
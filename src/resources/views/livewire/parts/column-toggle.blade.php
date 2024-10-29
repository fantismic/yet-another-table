<!-- Columns Button -->
<div x-data="{ isOpenColumnToggle: false}" class="relative " @keydown.esc.window="isOpenColumnToggle = false">
    <!-- Toggle Button -->
    <button @click="isOpenColumnToggle = ! isOpenColumnToggle" class="outline-none inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed bg-opacity-60 dark:bg-opacity-30 text-secondary-600 bg-secondary-300 dark:bg-secondary-600 dark:text-secondary-400 hover:bg-opacity-60 dark:hover:bg-opacity-30 hover:text-secondary-800 hover:bg-secondary-400 dark:hover:text-secondary-400 dark:hover:bg-secondary-500 focus:bg-opacity-60 dark:focus:bg-opacity-30 focus:ring-offset-2 focus:text-secondary-800 focus:bg-secondary-400 focus:ring-secondary-400 dark:focus:text-secondary-400 dark:focus:bg-secondary-500 dark:focus:ring-secondary-700 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
        {{ucfirst(__('yat::yat.columns'))}}
        <div>
            <svg 
                aria-hidden="true" 
                fill="none" 
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 24 24" 
                stroke-width="2" 
                stroke="currentColor" 
                class="w-4 h-4 transition-transform duration-300" 
                :class="!isOpenColumnToggle ? 'rotate-180' : 'rotate-0'"
            >
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M19.5 15.75l-7.5-7.5-7.5 7.5"
                />
            </svg>
        </div>
    </button>
    <!-- Dropdown Menu -->
    <div x-cloak x-show="isOpenColumnToggle" x-transition @click.outside="isOpenColumnToggle = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="shadow-xl min-w-52 z-30 absolute top-11 right-0 inline-block rounded-md whitespace-nowrap" role="menu">
        <ul class="rounded-md text-sm font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @if($handle_state)
            <li class="w-full border-b border-gray-200 rounded-t-lg rounded-md dark:border-gray-600">
                <div class="p-3">
                    <button 
                        wire:click="saveTableState" 
                        type="button" 
                        class="w-full outline-none inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed text-white bg-emerald-500 dark:bg-emerald-700 hover:text-white hover:bg-emerald-600 dark:hover:bg-emerald-600 focus:text-white focus:ring-offset-2 focus:bg-emerald-600 focus:ring-emerald-600 dark:focus:bg-emerald-600 dark:focus:ring-emerald-600 rounded-md gap-x-1 text-xs px-2.5 py-1.5"
                        wire:loading.attr="disabled"
                        wire:target="saveTableState"
                    >   
                        <span wire:loading.remove wire:target="saveTableState">{{ucfirst(__('yat::yat.save_column_election'))}}</span>
                        <span wire:loading wire:target="saveTableState" class="ml-2">{{ucfirst(__('yat::yat.saving'))}}...</span>
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
                <li class="w-full border-gray-200 hover:bg-gray-200  rounded-mc dark:border-gray-600 dark:hover:bg-gray-700">
                    <div class="flex items-center ps-3">
                        <input id="{{ $column->key }}" type="checkbox" wire:model.live="columns.{{ $key }}.isVisible" class="cursor-pointer w-4 h-4 text-gray-500 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="{{ $column->key }}" class="cursor-pointer pr-3  w-full py-2 ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $column->label }}</label>
                    </div>
                </li>
            @endif
        @endforeach       
        </ul>                 
    </div>
</div>
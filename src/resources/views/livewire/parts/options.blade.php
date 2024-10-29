<!-- Options Button -->
<div x-data="{ isOpenOptionsToggle: false}" class="relative" @keydown.esc.window="isOpenOptionsToggle = false">
    <!-- Toggle Button -->
    <button @click="isOpenOptionsToggle = ! isOpenOptionsToggle" class="outline-none inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed bg-opacity-60 dark:bg-opacity-30 text-secondary-600 bg-secondary-300 dark:bg-secondary-600 dark:text-secondary-400 hover:bg-opacity-60 dark:hover:bg-opacity-30 hover:text-secondary-800 hover:bg-secondary-400 dark:hover:text-secondary-400 dark:hover:bg-secondary-500 focus:bg-opacity-60 dark:focus:bg-opacity-30 focus:ring-offset-2 focus:text-secondary-800 focus:bg-secondary-400 focus:ring-secondary-400 dark:focus:text-secondary-400 dark:focus:bg-secondary-500 dark:focus:ring-secondary-700 rounded-md gap-x-2 text-sm px-4 py-2" type="button">
        {{ucfirst(__('yat::yat.options'))}}
        <div>
            <svg 
                aria-hidden="true" 
                fill="none" 
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 24 24" 
                stroke-width="2" 
                stroke="currentColor" 
                class="w-4 h-4 transition-transform duration-300" 
                :class="!isOpenOptionsToggle ? 'rotate-180' : 'rotate-0'"
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
    <div x-cloak x-show="isOpenOptionsToggle" x-transition @click.outside="isOpenOptionsToggle = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="shadow-xl min-w-52 z-30 absolute top-11 right-0 inline-block rounded-md whitespace-nowrap" role="menu">
        <ul class="rounded-md text-sm font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @foreach ($options as $function => $label)
            <li class="w-full border-b last:border-b-0 border-gray-200 hover:bg-gray-200 rounded-mc dark:border-gray-600 dark:hover:bg-gray-600">
                <div class="flex items-center ps-3 pr-3">
                    <div 
                        wire:click="{{$function}}" 
                        class="cursor-pointer w-full pr-3 py-3 ms-2 text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center" 
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
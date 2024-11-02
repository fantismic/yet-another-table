<div class="relative">
    <label 
        class="shadow rounded-md focus-within:ring-blue-400 dark:focus-within:ring-blue-400 bg-background-white dark:bg-background-dark relative flex justify-between gap-x-2 items-center transition-all ease-in-out duration-150 ring-1 ring-inset ring-gray-300 dark:ring-gray-500 focus-within:ring-2 outline-0 pl-3 pr-3 py-2 " 
        for="globalSearch" 
    >       
        <input 
            wire:model.live.debounce.200ms="yat_global_search" 
            placeholder="{{ $yat_global_search_label ?? ucfirst(__('yat::yat.search')) }}" 
            type="text" 
            class="min-w-[24rem] bg-transparent block w-full border-0 text-gray-900 dark:text-gray-400 p-0 outline-none ring-0 sm:text-sm sm:leading-6 focus:ring-0 focus:border-0 placeholder:text-gray-400 dark:placeholder:text-gray-500 " 
            autocomplete="off"
            id="globalSearch" 
            name="globalSearch"
        />             
    </label>
    <button 
        tabindex="-1"
        type="button" 
        class="absolute inset-y-0 right-0 flex items-center pr-3"
        x-show="!!$wire.get('yat_global_search')" 
        @click="$wire.set('yat_global_search', '');"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
<div class="min-w-20 rounded-md dark:text-gray-400 focus-within:ring-blue-400 dark:focus-within:ring-blue-400 shadow bg-background-white dark:bg-background-dark relative flex justify-between gap-x-2 items-center transition-all ease-in-out duration-150 ring-1 ring-inset ring-gray-300 dark:ring-gray-500 focus-within:ring-2 outline-0 pl-3 h-10">
    <select wire:model.live="perPage" class="bg-transparent block w-full border-0 text-gray-900 dark:text-gray-400 outline-none ring-0 sm:text-sm sm:leading-6 focus:ring-0 focus:border-0 placeholder:text-gray-400 dark:placeholder:text-gray-300 ">
        @foreach ($perPageOptions as $option)
                <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>  
</div>
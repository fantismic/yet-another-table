<div class="mt-4">
    @if($rows->lastPage() == 1)
    <div>
        <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
            <span>Showing all</span>
            <span class="font-medium">{{$rows->total()}}</span>
            <span>results</span>
        </p>
    </div>
    @endif
    {{ $rows->links() }}
</div>
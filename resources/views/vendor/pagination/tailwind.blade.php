@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $delta = 2; // Number of pages to show on each side of current page
                        
                        $range = [];
                        for ($i = max(1, $currentPage - $delta); $i <= min($lastPage, $currentPage + $delta); $i++) {
                            $range[] = $i;
                        }
                        
                        // Always show first page
                        if (!in_array(1, $range)) {
                            array_unshift($range, 1);
                        }
                        
                        // Always show last page
                        if (!in_array($lastPage, $range)) {
                            $range[] = $lastPage;
                        }
                        
                        // Add ellipsis if needed
                        $rangeWithEllipsis = [];
                        $previous = null;
                        foreach ($range as $page) {
                            if ($previous !== null && $page - $previous > 1) {
                                $rangeWithEllipsis[] = '...';
                            }
                            $rangeWithEllipsis[] = $page;
                            $previous = $page;
                        }
                    @endphp

                    @foreach ($rangeWithEllipsis as $page)
                        @if ($page === '...')
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">...</span>
                        @elseif ($page == $currentPage)
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#0c3252] border border-[#0c3252] cursor-default leading-5">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>

                {{-- Page Jump Input --}}
                <div class="ml-4 inline-flex items-center">
                    <form method="GET" class="inline-flex items-center" onsubmit="return validatePageInput(this)">
                        <input type="number" 
                               name="page" 
                               min="1" 
                               max="{{ $lastPage }}" 
                               class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Page">
                        <button type="submit" 
                                class="ml-2 px-3 py-1 text-sm font-medium text-white bg-[#0c3252] border border-[#0c3252] rounded-md hover:bg-[#0a2a45] focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            Go
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endif

<script>
function validatePageInput(form) {
    const input = form.querySelector('input[name="page"]');
    const maxPage = parseInt(input.getAttribute('max'));
    const value = parseInt(input.value);
    
    if (value < 1 || value > maxPage) {
        alert('Halaman harus antara 1 dan ' + maxPage);
        return false;
    }
    return true;
}
</script>
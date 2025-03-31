<div>
    @if (!empty($paginator))
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Previous
            </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150">
                        Previous
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150">
                        Next
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Next
            </span>
                @endif
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <!-- Per Page Selection Dropdown -->
                    <div class="mr-4">
                        <label for="perPage" class="sr-only">Items per page</label>
                        <select id="perPage" wire:model.live="perPage"
                                class="border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm py-1 px-4">
                            @php
                                $total = $paginator->total();
                                $options = [5, 10, 25, 50];

                                // Generate dynamic options based on total records
                                $current = 50;
                                while($current * 2 <= $total) {
                                    $current *= 2;
                                    if($current <= 1000) { // Safety limit for very large datasets
                                        $options[] = $current;
                                    }
                                }

                                // Always include the total if it's different from existing options
                                if($total > 50 && !in_array($total, $options)) {
                                    $options[] = $total;
                                }

                                // Filter options to only include values <= total
                                $filteredOptions = array_filter($options, fn($opt) => $opt <= $total);
                                $finalOptions = array_unique(array_merge(
                                    [5, 10, 25],
                                    $filteredOptions
                                ));
                                sort($finalOptions);
                            @endphp

                            @foreach($finalOptions as $option)
                                <option value="{{ $option }}">{{ $option }} per page</option>
                            @endforeach
                            <option value="all">Show All ({{ $total }})</option>
                        </select>
                    </div>

                    <p class="text-sm text-gray-700 leading-5">
                        Showing
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                <div>
                <span class="relative z-0 inline-flex shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    @else
                        <button wire:click="previousPage" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150" aria-label="Previous">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                        <span class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-black">{{ $element }}</span>
                    </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                        <span class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-gray-300 px-4 py-2 text-sm font-medium leading-5 text-black">{{ $page }}</span>
                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="pagination relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-black ring-gray-300 transition duration-150 ease-in-out hover:text-black hover:bg-gray-100 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-black">
                        {{ $page }}
                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150" aria-label="Next">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    @endif
                </span>
                </div>
            </div>
        </nav>
    @endif
</div>

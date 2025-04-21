<div>
    @if (!empty($paginator) && ($paginator->total() > 5))
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between px-4 py-3 bg-white rounded-lg shadow-xs">
            <!-- Mobile View -->
            <div class="flex justify-between flex-1 sm:hidden space-x-2">
                @if ($paginator->onFirstPage())
                    <span class="px-4 py-2 text-[10px] font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                            class="px-4 py-2 text-[10px] font-medium text-white bg-black border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all duration-200">
                        Previous
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                            class="px-4 py-2 text-[10px] font-medium text-white bg-black border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all duration-200">
                        Next
                    </button>
                @else
                    <span class="px-4 py-2 text-[10px] font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>

            <!-- Desktop View -->
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Per Page Selection -->
                    <div class="relative">
                        <label for="perPage" class="sr-only">Items per page</label>
                        <select id="perPage" wire:model.live="perPage"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-black focus:border-black sm:text-[10px] rounded-md shadow-sm">
                            @php
                                $total = $paginator->total();
                                $options = [5, 10, 25, 50];
                                if ($total > 50) $options[] = $total;
                            @endphp

                            @foreach($options as $option)
                                @if($option <= $total)
                                    <option value="{{ $option }}">{{ $option }} per page</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>

                <div>
                    <!-- Results Info -->
                    <p class="text-[10px] text-center text-gray-600">
                        Showing <span class="font-medium">{{ $paginator->firstItem() }}</span> to
                        <span class="font-medium">{{ $paginator->lastItem() }}</span> of
                        <span class="font-medium">{{ $paginator->total() }}</span> results
                    </p>
                </div>

                <!-- Pagination Controls -->
                <div class="flex items-center space-x-1 text-white">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                        {{-- Previous Page --}}
                        @if ($paginator->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <button wire:click="previousPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-all duration-200">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-[10px] font-medium text-gray-700">
                                    {{ $element }}
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-black bg-black text-[10px] font-medium text-white">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-[10px] font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-all duration-200">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px rounded-r-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-all duration-200">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px rounded-r-md border border-gray-300 bg-white text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>

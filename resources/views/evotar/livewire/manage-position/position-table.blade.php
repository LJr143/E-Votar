<div>
    <div class="overflow-x-auto sm:overflow-visible block mb-4">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click.debounce.500ms="$set('filter', 'all_position')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'all_position' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All Positions
                </button>
                <button wire:click.debounce.500ms="$set('filter', 'student_position')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'student_position' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Student Council Positions
                </button>
                <button wire:click.debounce.500ms="$set('filter', 'local_position')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'local_position' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Local Council Positions
                </button>
                <button wire:click.debounce.500ms="$set('filter', 'special_position')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'special_position' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Special Election Position
                </button>
            </nav>
        </div>
    </div>
    <div class="flex flex-col md:flex-row w-full gap-4">
        <div class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div class="sm:p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col lg:flex-row w-full items-center gap-2 justify-between">
                        <div class="flex items-center w-full lg:w-auto justify-between flex-wrap md:flex-nowrap gap-2">
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full xs:w-auto whitespace-nowrap text-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="exportPositions"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="exportPositions" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                     width="20px" fill="#000000">
                                    <path
                                        d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                </svg>
                                <span wire:loading.remove wire:target="exportPositions" class="text-[12px]">Export List of Positions</span>
                                <svg wire:loading wire:target="exportPositions" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="exportPositions">Exporting...</span>
                            </button>
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full xs:w-auto text-center  space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="$toggle('importing')"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="import" width="12" height="18" viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="#000000" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                                <span wire:loading.remove wire:target="import" class="text-[12px]">Import Positions</span>
                                <svg wire:loading wire:target="import" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="import">Importing...</span>
                            </button>
                            <!-- Import Modal -->
                            @if($importing)
                                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div class="bg-white p-6 rounded shadow-md max-w-md w-full mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12">
                                        <h3 class="text-lg font-medium text-center mb-4">Import Positions</h3>

                                        @if($importError || count($importErrors))
                                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                                                @if($importError)
                                                    <p class="font-semibold">{{ $importError }}</p>
                                                @endif

                                                @if(count($importErrors))
                                                    <div class="mt-2 max-h-60 overflow-y-auto">
                                                        <ul class="list-disc pl-5">
                                                            @foreach($importErrors as $error)
                                                                <li class="mt-1">
                                                                    <span class="font-medium">Row {{ $error['row'] }}</span>
                                                                    ({{ $error['field'] }}):
                                                                    {{ implode(', ', $error['errors']) }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @unless($importError || count($importErrors))
                                            <div class="mb-6 relative">
                                                <!-- File input with spinner to the right -->
                                                <div class="flex items-center">
                                                    <input type="file" wire:model="importFile"
                                                           class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                                    <!-- Spinner shown while file is uploading -->
                                                    <div wire:loading wire:target="importFile" class="flex items-center ml-2">
                                                        <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                             viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                                    stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                  d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endunless

                                        <div class="flex justify-end space-x-3">
                                            <button wire:click="resetImport()"
                                                    class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                                {{ $importError || count($importErrors) ? 'Close' : 'Cancel' }}
                                            </button>

                                            @unless($importError || count($importErrors))
                                                <button wire:click="import"
                                                        wire:loading.attr="disabled"
                                                        class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                                    <span wire:loading.remove wire:target="import">Import</span>
                                                    <span wire:loading wire:target="import">Importing...</span>
                                                </button>
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button
                                class="bg-green-600 border text-white border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full xs:w-auto whitespace-nowrap text-center mb-2 sm:mb-0 space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="downloadExcelFormat"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="downloadExcelFormat" width="12" height="18" viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="white" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                                <span wire:loading.remove wire:target="downloadExcelFormat" class="text-[12px]">Download excel format</span>
                                <svg wire:loading wire:target="downloadExcelFormat" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="downloadExcelFormat">Downloading...</span>
                            </button>
                        </div>

                        <div class="flex items-center gap-2 w-full lg:w-auto">
                            <div class="w-full lg:w-[250px]">
                                <!-- Search Input -->
                                <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                                    <span class="flex items-center">
                                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                        </svg>
                                    </span>
                                    <x-input type="text" wire:model.live="search"
                                             class="text-[12px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full h-8 px-2"
                                             placeholder="Search position..." aria-label="Search">
                                    </x-input>
                                </div>
                            </div>
                            <livewire:manage-position.add-position/>
                        </div>
                    </div>



                    <div class="mt-6 min-h-[300px] overflow-x-auto">
                        <table class="min-w-full whitespace-nowrap" id="positionsTable">
                            <thead>
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">ID</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Position Name</th>
                                <th class="py-3 px-6 text-center rounded-tr-lg border-b border-gray-300 exclude-print">Actions</th>
                            </tr>
                            </thead>
                            <tr></tr>
                            <tbody class="text-black text-[12px] font-light">
                            @foreach($positions as $position)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-6 text-left">{{ str_pad($position->id, 7, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $position->name }}</td>
                                    <td class="py-3 px-6 text-center flex justify-center space-x-2 items-center exclude-print">
                                        <livewire:manage-position.edit-position :positionId="$position->id" :key="'edit-position-'.$position->id" />
                                        <livewire:manage-position.delete-position :positionId="$position->id" :key="'delete-position-'.$position->id" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Empty State -->
                        @if ($positions->isEmpty())
                            <div class="border border-gray-200 rounded-md p-8 text-center">
                                <div class="flex justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <h3 class="text-[14px] font-medium mb-2">No positions found</h3>
                                <p class="text-[12px] text-gray-500">
                                    @if($search)
                                        No positions match your search criteria.
                                    @else
                                        No positions found.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        {{ $positions->links('evotar.components.pagination.tailwind-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printElections() {
            const excludeElements = document.querySelectorAll('.exclude-print');
            excludeElements.forEach(el => el.style.display = 'none');

            printJS({
                printable: 'positionsTable',
                type: 'html',
                scanStyles: true,
                style: `
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; font-weight: bold; }
        `
            });

            excludeElements.forEach(el => el.style.display = '');
        }
    </script>


</div>

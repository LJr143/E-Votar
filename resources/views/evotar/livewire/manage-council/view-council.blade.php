<div>
    <div class="flex w-full gap-4 min">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">
                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full sm:w-auto text-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="exportCouncils"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="exportCouncils" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                     width="20px" fill="#000000">
                                    <path
                                        d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                </svg>
                                <span wire:loading.remove wire:target="exportCouncils" class="text-[12px]">Export List of Councils</span>
                                <svg wire:loading wire:target="exportCouncils" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="exportCouncils">Exporting...</span>
                            </button>
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full sm:w-auto text-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="$toggle('importing')"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="import" width="12" height="18" viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="#000000" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                                <span wire:loading.remove wire:target="import" class="text-[12px]">Import Councils</span>
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
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                        <h3 class="text-lg font-medium mb-4">Import Councils</h3>

                                        @if($importError)
                                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                                                {{ $importError }}
                                            </div>
                                        @endif

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
                                        <div class="flex justify-end space-x-3">
                                            <button wire:click="$set('importing', false)"
                                                    class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                                Cancel
                                            </button>
                                            <button wire:click="import"
                                                    wire:loading.attr="disabled"
                                                    class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                                <span wire:loading.remove wire:target="import">Import</span>
                                                <span wire:loading wire:target="import">Importing...</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button
                                class="bg-green-600 border text-white border-gray-300 rounded h-8 px-3 py-2 flex items-center justify-center w-full sm:w-auto text-center mb-2 sm:mb-0 space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
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


                        <div class="flex items-center gap-2">
                            <div class="w-full md:w-[250px]">
                                <!-- Search Input -->
                                <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                                    <span class="flex items-center">
                                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                        </svg>
                                    </span>
                                    <x-input type="text" wire:model.live="search"
                                             class="text-[12px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full h-8 px-2"
                                             placeholder="Search elections..." aria-label="Search">
                                    </x-input>
                                </div>
                            </div>
                            <livewire:manage-council.add-council wire:key="add-council-btn"/>
                        </div>
                    </div>


                    <div class=" mt-4 overflow-x-auto min-h-[350px]">
                        <table class="min-w-full" id="partyListTable">
                            <thead class="text-left text-[10px]">
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                {{--                                <th class="py-3 px-6 rounded-tl-lg  border-b border-gray-300 exclude-print">--}}
                                {{--                                    <input class="form-checkbox text-left rounded h-4 w-4 text-black"--}}
                                {{--                                           x-model="selectAll"--}}
                                {{--                                           @click="checkboxes.forEach(checkbox => checkbox.checked = $event.target.checked)"--}}
                                {{--                                           type="checkbox">--}}
                                {{--                                </th>--}}
                                <th class="py-3 px-6 border-b border-gray-300">Id</th>
                                <th class="py-3 px-6 border-b border-gray-300">Council Name</th>
                                <th class="py-3 px-6 rounded-tr-lg border-b border-gray-300 exclude-print">Actions</th>
                            </tr>
                            </thead>

                            <tbody class="text-black text-[12px] font-light">
                            @foreach($councils as $council)
                                <tr class="border-b border-gray-100 rows" wire:key="council-buttons-{{$council->id}}">
                                    <td class="py-3 px-6 text-left">{{ $council->id }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $council->name }}</td>

                                    <td class="py-3 px-6 text-left exclude-print" wire:key="actions-{{ $council->id }}">
                                        <div class="flex space-x-2">
                                            <!-- Edit Council -->
                                            <livewire:manage-council.edit-council
                                                :councilId="$council->id"
                                                wire:key="edit-council-{{ $council->id }}"
                                            />

                                            <!-- Delete Council -->
                                            <livewire:manage-council.delete-council
                                                :councilId="$council->id"
                                                wire:key="delete-council-{{ $council->id }}"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4" wire:key="pagination-table">
                            {{ $councils->links('evotar.components.pagination.tailwind-pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function printPartyList() {
                const excludeElements = document.querySelectorAll('.exclude-print');
                excludeElements.forEach(el => el.style.display = 'none');

                printJS({
                    printable: 'partyListTable',
                    type: 'html',
                    scanStyles: true,
                    style: `
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

                body {
                    font-family: 'Poppins', sans-serif; /* Set Poppins as the overall font */
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                thead th {
                    font-size: 12px;
                    font-weight: bold;
                }
                tbody td {
                    font-size: 12px;
                    font-weight: 300;
                }
            `
                });

                excludeElements.forEach(el => el.style.display = '');
            }
        </script>

    </div>
</div>


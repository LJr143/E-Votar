<div class="container mx-auto mt-4 mb-4">
    <div class="flex flex-col md:flex-row w-full gap-4">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div class="sm:p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">
                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <div class="flex space-x-2 items-center mb-4 sm:mb-0">
                                <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                        onclick="printPartyList()">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                        <path d="M648-624v-120H312v120h-72v-192h480v192h-72Zm-480 72h625-625Zm539.79 96q15.21 0 25.71-10.29t10.5-25.5q0-15.21-10.29-25.71t-25.5-10.5q-15.21 0-25.71 10.29t-10.5 25.5q0 15.21 10.29 25.71t25.5 10.5ZM648-216v-144H312v144h336Zm72 72H240v-144H96v-240q0-40 28-68t68-28h576q40 0 68 28t28 68v240H720v144Zm73-216v-153.67Q793-530 781-541t-28-11H206q-16.15 0-27.07 11.04Q168-529.92 168-513.6V-360h72v-72h480v72h73Z"/>
                                    </svg>
                                    <span class="text-[12px]">Print</span>
                                </button>
                                <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                        <path d="M444-336v-342L339-573l-51-51 192-192 192 192-51 51-105-105v342h-72ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                    </svg>
                                    <span class="text-[12px]">Import</span>
                                </button>

                                <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                        <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                    </svg>
                                    <span class="text-[12px]">Export</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Search Bar -->
                            <div class="relative w-full md:w-[250px]">
                                <x-input type="text" wire:model.live="search"
                                         class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full"
                                         placeholder="Search elections..." aria-label="Search"></x-input>
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                                </svg>
                                            </span>
                            </div>

                            <!-- Button -->
                            @can('create party list')
                                <livewire:manage-party-list.add-party-list/>
                            @endcan
                        </div>
                    </div>


                    <div class="mt-6 overflow-x-auto min-h-[350px]">
                        <table class="min-w-full" id="partyListTable">
                            <thead class="text-left">
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 rounded-tl-lg  text-left border-b border-gray-300 exclude-print">
                                    <input class="form-checkbox rounded h-4 w-4 text-black"
                                           x-model="selectAll"
                                           @click="checkboxes.forEach(checkbox => checkbox.checked = $event.target.checked)"
                                           type="checkbox">
                                </th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Id</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Party List Name</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300 exclude-print">Members</th>
                                <th class="py-3 px-6 rounded-tr-lg border-b text-center border-gray-300 exclude-print">Actions</th>
                            </tr>
                            </thead>

                            <tbody class="text-black text-[12px] font-light">
                            @foreach($party_lists as $party_list)
                                <tr class="border-b border-gray-100 rows">
                                    <td class="py-3 px-6 text-left exclude-print">
                                        <input type="checkbox"
                                               class="form-checkbox rounded h-4 w-4 text-black row-checkbox">
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $party_list->id }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $party_list->name }}</td>
                                    <td class="py-3 px-6 text-left font-bold exclude-print">
                                        <div class="flex -space-x-2">
                                            <img alt="User  avatar 1" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/ZuTpJE6pJfJbppzY8Khmg-vOg6u2WXLzLMgz5_Uoc-0.jpg" width="24"/>
                                            <img alt="User  avatar 2" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/2pXhDPPK7gfhc2BafGJ_EAzRgUL9U11eKHP90gamIBo.jpg" width="24"/>
                                            <img alt="User  avatar 3" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/JiBdvOYQiJDmouspoR7oGEmdSCAvmDX0byxIpKTpbik.jpg" width="24"/>
                                            <img alt="User  avatar 4" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/-M0cg3Rd111OQRFnFY0nwtlNhSBGQiLq6cAOyZpeW5M.jpg" width="24"/>
                                            <!-- +2 Indicator -->
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-gray-800 text-[11px] font-semibold border-2 border-white">
                                                +2
                                            </div>
                                        </div>

                                    </td>

                                    <td class="py-3 px-6 text-center flex justify-center items-center exclude-print">
                                        @can('edit party list')
                                            <livewire:manage-party-list.view-party-list-members/>
                                        @endcan

                                    @can('edit party list')
                                            <livewire:manage-party-list.edit-party-list :partyListId="$party_list->id" :key="'edit-party-list'.$party_list->id"/>
                                        @endcan

                                        @can('delete party list')
                                        <livewire:manage-party-list.delete-party-list :partyListId="$party_list->id" :key="'delete-party-list'.$party_list->id"/>
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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


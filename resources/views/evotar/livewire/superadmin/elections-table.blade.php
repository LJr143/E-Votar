<div class="container mx-auto mt-4">
    <div class="mb-4">
        <div class="border-b-2 border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <button wire:click="$set('filter', 'all_elections')"
                        class=" whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'all_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All Elections
                </button>
                <button wire:click="$set('filter', 'ongoing_elections')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'ongoing_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Ongoing
                </button>
                <button wire:click="$set('filter', 'completed_elections')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'completed_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Completed
                </button>
            </nav>
        </div>
    </div>
    <div class="flex flex-col md:flex-row w-full gap-4">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div class="sm:p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">

                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <div class="flex space-x-2 items-center mb-4 sm:mb-0">
                                <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" onclick="printElections()">
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
                            @can('create election')<livewire:manage-election.add-election/>@endcan
                        </div>

                    </div>
                    <div class="mt-6 min-h-[400px] overflow-x-auto">
                        <table class="min-w-full" id="electionsTable">
                            <thead>
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300 exclude-print">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-black " x-model="selectAll" @click="checkboxes.forEach(checkbox => checkbox.checked = $event.target.checked)">
                                </th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">ID</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Election Name</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Type of Election</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Start Date</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">End Date</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Current Status</th>
                                <th class="py-3 px-6 text-center rounded-tr-lg border-b border-gray-300 exclude-print">Actions</th>
                            </tr>
                            </thead>
                            <tr></tr>
                            <tbody class="text-black text-[12px] font-light">
                            @foreach($elections as $election)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-6 text-left exclude-print">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ str_pad($election->id, 7, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $election->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $election->election_type->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $election->date_started }}</td>
                                    <td class="py-3 px-6 text-left">{{ $election->date_ended }}</td>
                                    <td class="py-3 px-6 text-white text-center">
                                        <p class="bg-green-600 w-[60px] rounded">{{ $election->status }}</p>
                                    </td>
                                    <td class="py-3 px-6 text-center flex justify-center items-center exclude-print">
                                        @can('view election')
                                            <livewire:manage-election.view-election :election_id="$election->id" :key="'view-election-'.$election->id" />@endcan
                                        @can('edit election')
                                            <div class="text-left">
                                                <livewire:manage-election.edit-election :election_id="$election->id" :key="'edit-election-'.$election->id" />
                                            </div>@endcan
                                        @can('delete election')
                                            <livewire:manage-election.delete-election :election_id="$election->id" :key="'delete-election-'.$election->id" />
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <div class="mt-4">
                            {{ $elections->links('evotar.components.pagination.tailwind-pagination') }}
                        </div>
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
                printable: 'electionsTable',
                type: 'html',
                scanStyles: true,
                style: `
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; font-weight: bold; }
        `
            });

            excludeElements.forEach(el => el.style.display = ''); // Show them again
        }
    </script>


</div>

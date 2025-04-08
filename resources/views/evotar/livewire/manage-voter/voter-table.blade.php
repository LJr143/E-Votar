<div class="container mx-auto mt-4 mb-4">
    <div class="flex flex-col md:flex-row w-full gap-4">
        <div class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="sm:p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">
                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="exportVoterLists"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="exportVoterLists"
                                     xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                     width="20px" fill="#000000">
                                    <path
                                        d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                </svg>
                                <span wire:loading.remove wire:target="exportVoterLists" class="text-[12px]">Export List of Voters</span>
                                <svg wire:loading wire:target="exportVoterLists" class="animate-spin h-5 w-5 mr-3"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="exportVoterLists">Exporting...</span>
                            </button>
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="$toggle('importing')"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="import" width="12" height="18" viewBox="0 0 16 19"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="#000000" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                                <span wire:loading.remove wire:target="import" class="text-[12px]">Import Voters</span>
                                <svg wire:loading wire:target="import" class="animate-spin h-5 w-5 mr-3"
                                     viewBox="0 0 24 24">
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
                                        <h3 class="text-lg font-medium mb-4">Import Voters</h3>

                                        @if($importError)
                                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                                                {{ $importError }}
                                            </div>
                                        @endif

                                        <input type="file" wire:model="importFile" class="mb-4 w-full">

                                        <div class="flex justify-end space-x-3">
                                            <button wire:click="$set('importing', false)"
                                                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                                Cancel
                                            </button>
                                            <button wire:click="import"
                                                    wire:loading.attr="disabled"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                <span wire:loading.remove wire:target="import">Import</span>
                                                <span wire:loading wire:target="import">Importing...</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button
                                class="bg-green-600 border text-white border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="downloadExcelFormat"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="downloadExcelFormat" width="12" height="18"
                                     viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="white" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                                <span wire:loading.remove wire:target="downloadExcelFormat" class="text-[12px]">Download excel format</span>
                                <svg wire:loading wire:target="downloadExcelFormat" class="animate-spin h-5 w-5 mr-3"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="downloadExcelFormat">Downloading...</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Search Bar -->
                            <div class="relative w-full md:w-[250px]">
                                <x-input type="text" wire:model.live="search"
                                         class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full"
                                         placeholder="Search elections..." aria-label="Search"></x-input>
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <svg width="12" height="12" viewBox="0 0 14 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z"
                                              fill="#000000"/>
                                    </svg>
                                </span>
                            </div>

                            <!-- Button -->

                            <div class="flex flex-col sm:flex-row sm:justify-center w-full md:w-auto">
                                @can('create voter')
                                    <a href="{{ route('votar.registration') }}"
                                       class="w-[120px] h-8 rounded bg-gradient-to-b from-gray-800 to-black text-white text-[12px] flex items-center justify-center gap-2 hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                        Voter Registration
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 overflow-x-auto min-h-[400px]" x-data="{
                                selectAll: false,
                                checkboxes: [],
                                init() {
                                    this.checkboxes = Array.from(document.querySelectorAll('.row-checkbox'));
                                    // Update selectAll when individual checkboxes change
                                    this.checkboxes.forEach(checkbox => {
                                        checkbox.addEventListener('change', () => {
                                            this.selectAll = this.checkboxes.every(c => c.checked);
                                        });
                                    });
                                },
                                toggleSelectAll() {
                                    this.checkboxes.forEach(checkbox => {
                                        checkbox.checked = this.selectAll;
                                    });
                                }
                            }" wire:key="voter-table">
                        <table class="min-w-full w-full" id="votersTable">
                            <thead class="text-left">
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-center rounded-tl-lg border-b border-gray-300 exclude-print">
                                    <input type="checkbox" class="form-checkbox rounded h-4 w-4 text-black"
                                           x-model="selectAll"
                                           @change="toggleSelectAll()">
                                </th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Voter ID</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Name</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Student ID</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Email</th>
                                {{--                                <th class="px-4 py-3 text-[12px] text-left w-[18ch]">College</th>--}}
                                <th class="py-3 px-6 border-b text-left border-gray-300">Program</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Major</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Year</th>
                                <th class="py-3 px-6 border-b text-left border-gray-300">Account Status</th>
                                <th class="py-3 px-6 rounded-tr-lg border-b text-center border-gray-300 exclude-print">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-black text-[12px] font-light">
                            @foreach($voters as $voter)
                                <tr class="border-b border-gray-100 rows">
                                    <td class="py-3 px-6 text-left exclude-print">
                                        <input type="checkbox"
                                               class="form-checkbox rounded h-4 w-4 text-black row-checkbox">
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $voter->id }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $voter->first_name }} {{ $voter->last_name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $voter->student_id }}</td>
                                    <td class="py-3 px-6 text-left">{{ $voter->email }}</td>
                                    {{--                                    <td class="px-4 py-1 text-[12px]">{{ $voter->college->name }}</td>--}}
                                    <td class="py-3 px-6 text-left">
                                        @php
                                            // Convert program names
                                            $program = $voter->program->name;
                                            if (str_starts_with($program, 'Bachelor of Science')) {
                                                $program = 'BS ' . substr($program, strlen('Bachelor of Science '));
                                            } elseif (str_starts_with($program, 'Bachelor of Education')) {
                                                $program = 'BE ' . substr($program, strlen('Bachelor of Education '));
                                            } elseif (str_starts_with($program, 'Bachelor of Technical-Vocation')) {
                                                $program = 'BTV ' . substr($program, strlen('Bachelor of Technical-Vocation'));
                                            }
                                            echo $program;
                                        @endphp
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $voter->programMajor->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $voter->year_level }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span
                                            class="inline-block w-24 px-2 py-1 text-center rounded @if($voter->account_status == 'Active') bg-green-500 text-white @elseif($voter->account_status == 'Deactivated') bg-red-500 text-white @else bg-yellow-500 text-white @endif">
                                            {{ $voter->account_status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center flex justify-center items-center exclude-print">
                                        <div class="inline-flex">
                                            @can('edit voter')
                                                <livewire:manage-voter.edit-voter :userId="$voter->id"
                                                                                  :key="'edit-election-'.$voter->id"/>
                                            @endcan
                                            @can('delete voter')
                                                <livewire:manage-voter.delete-voter :userId="$voter->id"
                                                                                    :key="'delete-election-'.$voter->id"/>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4" wire:key="voter-pagination">
                            {{ $voters->links('evotar.components.pagination.tailwind-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printVoters() {
            const excludeElements = document.querySelectorAll('.exclude-print');
            excludeElements.forEach(el => el.style.display = 'none');

            printJS({
                printable: 'votersTable',
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

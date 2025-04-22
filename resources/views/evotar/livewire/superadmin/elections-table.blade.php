<div class="mt-4">
    <div class="mb-4">
        <div class="border-b-2 border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <button wire:click="$set('filter', 'all_elections')"
                        class=" whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'all_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All Elections
                </button>
                <button wire:click="$set('filter', 'pending_elections')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'pending_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Pending
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
                <div
                    class="sm:p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">

                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <div class="flex space-x-2 items-center mb-4 sm:mb-0">
                                <button
                                    class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                    onclick="printElections()">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                         width="20px" fill="#000000">
                                        <path
                                            d="M648-624v-120H312v120h-72v-192h480v192h-72Zm-480 72h625-625Zm539.79 96q15.21 0 25.71-10.29t10.5-25.5q0-15.21-10.29-25.71t-25.5-10.5q-15.21 0-25.71 10.29t-10.5 25.5q0 15.21 10.29 25.71t25.5 10.5ZM648-216v-144H312v144h336Zm72 72H240v-144H96v-240q0-40 28-68t68-28h576q40 0 68 28t28 68v240H720v144Zm73-216v-153.67Q793-530 781-541t-28-11H206q-16.15 0-27.07 11.04Q168-529.92 168-513.6V-360h72v-72h480v72h73Z"/>
                                    </svg>
                                    <span class="text-[12px]">Print</span>
                                </button>

                                <button
                                    class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                    wire:click="exportElection"
                                    wire:loading.attr="disabled">
                                    <svg wire:loading.remove wire:target="exportElection" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                         width="20px" fill="#000000">
                                        <path
                                            d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                    </svg>
                                    <span wire:loading.remove wire:target="exportElection" class="text-[12px]">Export List of Elections</span>
                                    <svg wire:loading wire:target="exportElection" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading wire:target="exportElection">Exporting...</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Search Bar -->
                            <div class="w-full md:w-[250px]">
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

                            <!-- Button -->
                            @can('create election')
                                <livewire:manage-election.add-election/>
                            @endcan
                        </div>

                    </div>
                    <div class="mt-6 min-h-[400px] overflow-x-auto" x-data="{
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
                            }" wire:key="election_table">
                        <table class="min-w-full" id="electionsTable">
                            <thead>
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-center rounded-tl-lg border-b border-gray-300 exclude-print">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-black"
                                           x-model="selectAll"
                                           @change="toggleSelectAll()">
                                </th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">Election ID</th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">Election Name</th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">Type of Election</th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">Start Date</th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">End Date</th>
                                <th class="py-3 px-6 text-center border-b border-gray-300">Current Status</th>
                                <th class="py-3 px-6 text-center rounded-tr-lg border-b border-gray-300 exclude-print">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-black text-[12px] font-light">
                            @foreach($elections as $election)
                                <tr class="border-b border-gray-100" wire:key="election-{{$election->id}}">
                                    <td class="py-3 px-6 text-center exclude-print">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox"
                                               x-ref="rowCheckbox">
                                    </td>
                                    <td class="py-3 px-6 text-center">{{ str_pad($election->id, 7, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-6 text-center font-bold">{{ $election->name }}</td>
                                    <td class="py-3 px-6 text-center">{{ $election->election_type->name }}</td>
                                    <td class="py-3 px-6 text-center">{{ $election->date_started }}</td>
                                    <td class="py-3 px-6 text-center">{{ $election->date_ended }}</td>
                                    <td class="py-4 px-6 text-white text-center">
                                        <p class="@if($election->status == 'ongoing') bg-red-500 @elseif($election->status == 'pending') bg-yellow-500
                                               @elseif($election->status == 'completed')  bg-black   @endif w-[100px] py-2 px-2 rounded">{{ ucfirst($election->status) }}</p>
                                    </td>
                                    <td class="py-3 px-6 text-center flex justify-center space-x-2 items-center exclude-print">
                                        @can('view election')
                                            <livewire:manage-election.view-election :election_id="$election->id"
                                                                                    wire:key="view-{{$election->id}}"/>
                                        @endcan
                                        @can('edit election')
                                            <div class="text-left">
                                                <livewire:manage-election.edit-election :election_id="$election->id"
                                                                                        wire:key="edit-{{$election->id}}"/>
                                            </div>
                                        @endcan
                                        @can('delete election')
                                            <livewire:manage-election.delete-election :election_id="$election->id"
                                                                                      wire:key="delete-{{$election->id}}"/>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Empty State -->
                        @if ($elections->isEmpty())
                            <div class="border border-gray-200 rounded-md p-8 text-center">
                                <div class="flex justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <h3 class="text-[14px] font-medium mb-2">No elections found</h3>
                                <p class="text-[12px] text-gray-500">
                                    @if($search)
                                        No elections match your search criteria.
                                    @else
                                        No elections found.
                                    @endif
                                </p>
                            </div>
                        @endif
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
            // Get all checked checkboxes
            const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');

            // If no rows are selected, show alert and return
            if (checkedCheckboxes.length === 0) {
                alert('Please select at least one election to preview as PDF.');
                return;
            }

            // Initialize jsPDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4'); // Portrait, millimeters, A4 size

            // Add logo
            const img = new Image();
            const img1 = new Image();
            const img2 = new Image();

            img.src = "/storage/assets/logo/tsc_comelec_logo.png"; // Adjust path
            img1.src = "/storage/assets/logo/usg_logo.png";
            img2.src = "/storage/assets/logo/usep_logo.jpg";
            doc.addImage(img, "PNG", 110, 12, 15, 15); // (X, Y, Width, Height)
            doc.addImage(img1, "PNG", 155, 12, 15, 15);
            doc.addImage(img2, "PNG", 130, 10, 20, 20);


            // Add document title
            doc.setFont("helvetica", "bolditalic");
            doc.setFontSize(10);
            doc.text("University of Southeastern Philippines - Tagum Unit", 140, 35, { align: "center" });
            doc.text("List of Official Elections", 140, 40, { align: "center" });
            doc.setFont("helvetica", "bold");
            doc.setFontSize(10);
            doc.text("University's Commission on Student Elections", 140, 45, { align: "center" });
            doc.setFont("helvetica", "italic");
            doc.setFontSize(10);
            doc.text(`Generated on: ${new Date().toLocaleString()}`, 45, 52, { align: "center" });

            // Table Data
            const tableData = [];
            const tableHeaders = [];

            // Get the original table
            const originalTable = document.getElementById('electionsTable');
            const originalThead = originalTable.querySelector('thead');

            // Get Headers (Skipping Checkbox and Action column)
            const headerCells = originalThead.querySelectorAll('th');
            headerCells.forEach((th, index) => {
                if (index !== 0 && index !== headerCells.length - 1) { // Skip first (checkbox) & last (Action)
                    tableHeaders.push(th.innerText);
                }
            });

            // Extract selected rows
            checkedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const rowData = [];
                row.querySelectorAll('td').forEach((td, index) => {
                    if (index !== 0 && index !== row.children.length - 1) { // Skip checkbox & actions column
                        rowData.push(td.innerText);
                    }
                });
                tableData.push(rowData);
            });

            doc.autoTable({
                head: [tableHeaders],
                body: tableData,
                startY: 55, // Start table below title
                theme: "grid",
                styles: { fontSize: 10, cellPadding: 3 },
                headStyles: { fillColor: [44, 62, 80], textColor: 255, fontStyle: "bold" },
                alternateRowStyles: { fillColor: [230, 230, 230] }
            });

            window.open(doc.output("bloburl"), "_blank");
        }

    </script>


</div>

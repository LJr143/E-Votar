<div class="mx-auto bg-white rounded-lg shadow-md p-6">
    <!-- Backup Creation Section (unchanged) -->
    <div class="mb-8 p-4 border border-gray-200 rounded-lg">
        <h2 class="text-sm font-semibold mb-4">Create New Backup Schedule</h2>
        <form wire:submit.prevent="createBackupSchedule" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Backup Name</label>
                <input type="text" wire:model.live="backupName" class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black">
                @error('backupName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Schedule Type</label>
                <select wire:model.live="scheduleType" class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black">
                    <option value="hourly">Hourly</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="custom">Custom Time</option>
                </select>
                @error('scheduleType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'custom'" x-cloak>
                <label class="block text-xs font-medium text-gray-700 mb-1">Specific Time</label>
                <input type="time" wire:model.live="customTime" class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black">
                @error('customTime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'weekly'" x-cloak>
                <label class="block text-xs font-medium text-gray-700 mb-1">Day of Week</label>
                <select wire:model.live="dayOfWeek" class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black">
                    @foreach ($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                    @endforeach
                </select>
                @error('dayOfWeek') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'monthly'" x-cloak>
                <label class="block text-xs font-medium text-gray-700 mb-1">Day of Month</label>
                <input type="number" wire:model.live="dayOfMonth" min="1" max="31" class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black">
                @error('dayOfMonth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2 flex justify-end mt-3">
                <button type="submit"
                        class="w-full sm:w-[200px] rounded-md px-4 py-2 bg-gradient-to-b from-gray-800 to-black text-white text-[12px] flex items-center justify-center gap-2 hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                        wire:loading.attr="disabled" wire:target="createBackupSchedule">
                    <span wire:loading.remove wire:target="createBackupSchedule">Create Schedule</span>
                    <span wire:loading wire:target="createBackupSchedule">Creating...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Backup Records Table -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <div class="flex flex-row items-center space-x-0 sm:space-x-2 gap-4 sm:gap-0">
            <button onclick="exportSelectedBackups()"
                    class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                     width="20px" fill="#000000">
                    <path
                        d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                </svg>
                <span class="text-[12px]">Export Selected</span>
            </button>

            <input type="date" wire:model.live="filterDate" class="bg-white border border-gray-300 rounded h-8 px-3 py-2 text-[12px] focus:ring-black focus:border-black">
        </div>

        <!-- Search Bar -->
        <div class="w-full md:w-64">
            <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                <span class="flex items-center">
                    <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                    </svg>
                </span>
                <input type="text" wire:model.live="search"
                       class="text-[12px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full h-8 px-2"
                       placeholder="Search backups..." aria-label="Search">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto min-h-[400px]" x-data="tableHandler()">
        <table class="min-w-full" id="backupRecordsTable">
            <thead>
            <tr class="w-full bg-gray-100 text-gray-700 uppercase text-xs leading-normal border-b border-gray-300 whitespace-nowrap">
                <th class="py-3 px-6 text-center rounded-tl-lg">
                    <input type="checkbox" class="form-checkbox rounded h-4 w-4 text-black" x-model="selectAll" @change="toggleSelectAll()">
                </th>
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Type</th>
                <th class="py-3 px-6 text-left">Next Backup</th>
                <th class="py-3 px-6 text-left">Last Backup</th>
                <th class="py-3 px-6 text-left">Files</th>
                <th class="py-3 px-6 text-center rounded-tr-lg">Actions</th>
            </tr>
            </thead>
            <tbody class="text-black text-[12px] font-light">
            @forelse ($backups as $backup)
                <tr class="border-b border-gray-100 whitespace-nowrap" wire:key="backup-{{ $backup->id }}">
                    <td class="py-3 px-6 text-center">
                        <input type="checkbox" class="form-checkbox rounded h-4 w-4 text-black row-checkbox" x-ref="rowCheckbox" value="{{ $backup->id }}">
                    </td>
                    <td class="py-3 px-6 text-left">{{ $backup->id }}</td>
                    <td class="py-3 px-6 text-left font-bold">{{ $backup->name }}</td>
                    <td class="py-3 px-6 text-left">
                        <span class="px-2 py-1 text-xs rounded {{ $backup->schedule_type === 'custom' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($backup->schedule_type) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-left">{{ $backup->next_backup_at?->toDateTimeString() ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $backup->last_backup_at?->toDateTimeString() ?? 'Never' }}</td>
                    <td class="py-3 px-6 text-left">
                        {{ $backup->backup_files_count }}
                        @if ($backup->backup_files_count > 0)
                            <div class="relative inline-block">
                                <button class="ml-2 text-blue-600 hover:underline" @click="$refs.filesDropdown{{ $backup->id }}.classList.toggle('hidden')">
                                    View
                                </button>
                                <div class="absolute z-10 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg hidden" x-ref="filesDropdown{{ $backup->id }}">
                                    @foreach ($backup->backupFiles as $file)
                                        <div class="px-4 py-2 hover:bg-gray-100 flex justify-between items-center">
                                            <span class="truncate">{{ basename($file->file_path) }}</span>
                                            <button
                                                wire:click="downloadBackupFile({{ $file->id }})"
                                                class="text-blue-500 hover:text-blue-700 whitespace-nowrap ml-2"
                                            >
                                                Download
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="py-3 px-2 sm:px-4 md:px-6 text-center whitespace-nowrap">
                        <div class="flex justify-center items-center space-x-2">
                            <button
                                wire:click="runBackupNow({{ $backup->id }})"
                                wire:loading.attr="disabled"
                                wire:target="runBackupNow({{ $backup->id }})"
                                class="px-2 py-1 sm:px-3 bg-green-500 text-white rounded text-xs hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 whitespace-nowrap">
                                <span wire:loading.remove wire:target="runBackupNow({{ $backup->id }})">Run Now</span>
                                <span wire:loading wire:target="runBackupNow({{ $backup->id }})">Running...</span>
                            </button>
                            <button
                                wire:click="deleteBackup({{ $backup->id }})"
                                wire:target="deleteBackup({{ $backup->id }})"
                                class="px-2 py-1 sm:px-3 bg-red-500 text-white rounded text-xs hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 whitespace-nowrap">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="py-4 text-center text-gray-500">No backup schedules found</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $backups->links('evotar.components.pagination.tailwind-pagination') }}
        </div>
    </div>
</div>

<script>
    function tableHandler() {
        return {
            selectAll: false,
            checkboxes: [],
            init() {
                this.updateCheckboxes();
                Livewire.hook('message.processed', () => this.updateCheckboxes());
            },
            updateCheckboxes() {
                this.checkboxes = Array.from(document.querySelectorAll('.row-checkbox'));
                this.checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        this.selectAll = this.checkboxes.every(c => c.checked);
                    });
                });
            },
            toggleSelectAll() {
                this.checkboxes.forEach(checkbox => checkbox.checked = this.selectAll);
            }
        }
    }

    function exportSelectedBackups() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        if (!checked.length) {
            alert('Please select at least one backup schedule to export.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        doc.setFontSize(16);
        doc.text('Database Backup Schedules', 148.5, 20, { align: 'center' });
        doc.setFontSize(10);
        doc.text(`Generated: ${new Date().toLocaleString()}`, 148.5, 30, { align: 'center' });

        const tableData = [];
        const headers = ['ID', 'Name', 'Type', 'Next Backup', 'Last Backup', 'Files'];

        checked.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const cells = row.querySelectorAll('td');
            tableData.push([
                cells[1].textContent,
                cells[2].textContent,
                cells[3].textContent,
                cells[4].textContent,
                cells[5].textContent,
                cells[6].textContent,
            ]);
        });

        doc.autoTable({
            head: [headers],
            body: tableData,
            startY: 40,
            theme: 'striped',
            styles: { fontSize: 10, cellPadding: 2 },
            headStyles: { fillColor: [66, 139, 202], textColor: 255 },
        });

        window.open(doc.output('bloburl'), '_blank');
    }

    document.addEventListener('notify', event => {
        const { type, message } = event.detail;
        console.log(`${type}: ${message}`);
    });
</script>

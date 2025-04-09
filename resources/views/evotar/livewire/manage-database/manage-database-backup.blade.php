<div class="mx-auto bg-white rounded-lg shadow-md p-6">
    <!-- Backup Creation Section (unchanged) -->
    <div class="mb-8 p-4 border border-gray-200 rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Create New Backup Schedule</h2>
        <form wire:submit.prevent="createBackupSchedule" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Backup Name</label>
                <input type="text" wire:model.live="backupName" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('backupName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Type</label>
                <select wire:model.live="scheduleType" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="hourly">Hourly</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="custom">Custom Time</option>
                </select>
                @error('scheduleType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'custom'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Specific Time</label>
                <input type="time" wire:model.live="customTime" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('customTime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'weekly'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Day of Week</label>
                <select wire:model.live="dayOfWeek" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                    @endforeach
                </select>
                @error('dayOfWeek') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.scheduleType === 'monthly'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Day of Month</label>
                <input type="number" wire:model.live="dayOfMonth" min="1" max="31" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('dayOfMonth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2 flex justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" wire:loading.attr="disabled" wire:target="createBackupSchedule">
                    <span wire:loading.remove wire:target="createBackupSchedule">Create Schedule</span>
                    <span wire:loading wire:target="createBackupSchedule">Creating...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Backup Records Table -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <div class="flex flex-col sm:flex-row items-center space-x-0 sm:space-x-4 gap-4 sm:gap-0">
            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live="search" placeholder="Search backups..." class="w-full pl-8 pr-4 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-2.5 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <input type="date" wire:model.live="filterDate" class="py-2 px-3 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button onclick="exportSelectedBackups()" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            Export Selected
        </button>
    </div>

    <div class="overflow-x-auto" x-data="tableHandler()">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg" id="backupRecordsTable">
            <thead>
            <tr class="bg-gray-100 text-gray-700 uppercase text-xs leading-normal">
                <th class="py-3 px-6 text-center rounded-tl-lg">
                    <input type="checkbox" class="form-checkbox rounded h-4 w-4 text-blue-600" x-model="selectAll" @change="toggleSelectAll()">
                </th>
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Type</th>
                <th class="py-3 px-6 text-left">Next Backup</th>
                <th class="py-3 px-6 text-left">Last Backup</th>
                <th class="py-3 px-6 text-left">Files</th>
                <th class="py-3 px-6 text-left rounded-tr-lg">Actions</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
            @forelse ($backups as $backup)
                <tr class="border-b border-gray-200 hover:bg-gray-50" wire:key="backup-{{ $backup->id }}">
                    <td class="py-3 px-6 text-center">
                        <input type="checkbox" class="form-checkbox rounded h-4 w-4 text-blue-600 row-checkbox" x-ref="rowCheckbox" value="{{ $backup->id }}">
                    </td>
                    <td class="py-3 px-6">{{ $backup->id }}</td>
                    <td class="py-3 px-6">{{ $backup->name }}</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 text-xs rounded {{ $backup->schedule_type === 'custom' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($backup->schedule_type) }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $backup->next_backup_at?->toDateTimeString() ?? 'N/A' }}</td>
                    <td class="py-3 px-6">{{ $backup->last_backup_at?->toDateTimeString() ?? 'Never' }}</td>
                    <td class="py-3 px-6">
                        {{ $backup->backup_files_count }}
                        @if ($backup->backup_files_count > 0)
                            <div class="relative inline-block">
                                <button class="ml-2 text-blue-600 hover:underline" @click="$refs.filesDropdown{{ $backup->id }}.classList.toggle('hidden')">View</button>
                                <div class="absolute z-10 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg hidden" x-ref="filesDropdown{{ $backup->id }}">
                                    @foreach ($backup->backupFiles as $file)
                                        <div class="px-4 py-2 hover:bg-gray-100 flex justify-between">
                                            <span>{{ basename($file->file_path) }}</span>
                                            <button wire:click="downloadBackupFile({{ $file->id }})" class="text-blue-500 hover:text-blue-700">Download</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex space-x-2">
                            <button wire:click="runBackupNow({{ $backup->id }})" wire:loading.attr="disabled" wire:target="runBackupNow({{ $backup->id }})" class="px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="runBackupNow({{ $backup->id }})">Run Now</span>
                                <span wire:loading wire:target="runBackupNow({{ $backup->id }})">Running...</span>
                            </button>
                            <button wire:click="deleteBackup({{ $backup->id }})" wire:target="deleteBackup({{ $backup->id }})" class="px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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

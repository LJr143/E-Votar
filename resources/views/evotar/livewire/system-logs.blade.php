<!-- resources/views/livewire/activity-logs.blade.php -->
<div>
    <div class="flex w-full gap-4 min">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                        <div class="flex space-x-2">
                            @if(count($selectedLogs) > 0)
                                <button wire:click="exportSelected" class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                        <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                    </svg>
                                    <span class="text-[12px]">Export</span>
                                </button>
                                <button wire:click="deleteSelected" class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                                    </svg>
                                    <span class="text-[12px]">Delete</span>
                                </button>
                            @endif
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-center gap-3 md:gap-3 w-full md:w-auto mt-2 relative z-50">
                            <div class="relative w-full sm:w-[250px] mb-4">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..." aria-label="Search"
                                       class="w-full rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-4 min-h-[350px]">
                        <table class="min-w-full">
                            <thead>
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">
                                    <input
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-black"
                                        wire:model.live="selectAll"
                                    >
                                </th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Performed By</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300 cursor-pointer" wire:click="sortBy('action')">
                                    Action
                                    @if($sortField === 'action')
                                        @if($sortDirection === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Target</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Details</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300 cursor-pointer" wire:click="sortBy('created_at')">
                                    Timestamp
                                    @if($sortField === 'created_at')
                                        @if($sortDirection === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </th>
                                <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300">Device & Location</th>
                            </tr>
                            </thead>
                            <tbody class="text-black text-[12px] font-light">
                            @foreach($logs as $log)
                                @php
                                    $ipDetails = $log->data['ip_details'] ?? null;
                                    $device = $ipDetails['device'] ?? null;
                                    $performedBy = $log->data['performed_by'] ?? null;
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">
                                        <input
                                            type="checkbox"
                                            class="form-checkbox h-4 w-4 text-black row-checkbox"
                                            wire:model.live="selectedLogs"
                                            value="{{ $log->id }}"
                                        >
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="font-bold">{{ $log->user->name ?? ($performedBy['name'] ?? 'System') }}</div>
                                        @if($log->user_id)
                                            <div class="text-gray-500 text-[10px]">ID: {{ $log->user_id }}</div>
                                        @elseif(isset($performedBy['id']))
                                            <div class="text-gray-500 text-[10px]">User ID: {{ $performedBy['id'] }}</div>
                                        @endif
                                        @if(!empty($performedBy['roles']))
                                            <div class="mt-1">
                                                @foreach($performedBy['roles'] as $role)
                                                    <span class="inline-block bg-gray-200 rounded-full px-2 py-0.5 text-[9px] font-semibold text-gray-700 mr-1 mb-1">
                                    {{ $role }}
                                </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">
                    <span @class([
                        'px-2 py-1 rounded-full text-[10px] font-medium',
                        'bg-blue-100 text-blue-800' => in_array($log->action, ['created', 'login', 'activate']),
                        'bg-yellow-100 text-yellow-800' => in_array($log->action, ['updated', 'modified']),
                        'bg-red-100 text-red-800' => in_array($log->action, ['deleted', 'logout', 'deactivate']),
                        'bg-gray-100 text-gray-800' => true
                    ])>
                        {{ ucfirst($log->action) }}
                    </span>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        @if($log->model_type && $log->model_id)
                                            @php
                                                $modelClass = $log->model_type;
                                                $model = $modelClass::find($log->model_id);
                                            @endphp
                                            @if($model)
                                                <div class="font-medium">{{ class_basename($modelClass) }} #{{ $model->id }}</div>
                                                @if(method_exists($model, 'getName'))
                                                    <div class="text-gray-500 text-[10px]">{{ $model->getName() }}</div>
                                                @elseif(isset($model->name))
                                                    <div class="text-gray-500 text-[10px]">{{ $model->name }}</div>
                                                @elseif(isset($model->title))
                                                    <div class="text-gray-500 text-[10px]">{{ $model->title }}</div>
                                                @endif
                                            @else
                                                <div class="text-gray-400 italic">[Deleted Record]</div>
                                            @endif
                                        @else
                                            <div class="text-gray-400">System</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="font-medium">{{ $log->description }}</div>
                                        @if($log->data['changes'] ?? false)
                                            <div class="mt-1 text-[10px]">
                                                @foreach($log->data['changes'] as $change)
                                                    <div class="mb-1">
                                                        <span class="font-semibold">{{ $change['field'] }}:</span>
                                                        <span class="text-red-500 line-through">{{ $change['old'] ?? 'null' }}</span>
                                                        <span>→</span>
                                                        <span class="text-green-600">{{ $change['new'] ?? 'null' }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($log->data['impersonator_id'] ?? false)
                                            <div class="mt-1 text-[10px] text-purple-600">
                                                Impersonated by user #{{ $log->data['impersonator_id'] }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="font-bold">{{ $log->created_at->format('m/d/Y') }}</div>
                                        <div class="text-gray-500 text-[11px]">{{ $log->created_at->format('h:i:s A') }}</div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        @if($ipDetails)
                                            <div class="flex items-center gap-2">
                                                @if($device['os'] ?? false)
                                                    <span class="inline-flex items-center">
                                    @if(str_contains(strtolower($device['os']), 'windows'))
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801"/></svg>
                                                        @elseif(str_contains(strtolower($device['os']), 'mac'))
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                                                        @endif
                                                        {{ $device['os'] }}
                                </span>
                                                @endif
                                                @if($device['browser'] ?? false)
                                                    <span class="inline-flex items-center">
                                    @if(str_contains(strtolower($device['browser']), 'chrome'))
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 15.6A3.6 3.6 0 1 1 12 8.4a3.6 3.6 0 0 1 0 7.2zm0-1.6a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm9.4-2c0 5.5-4.5 10-10 10-4.3 0-8-2.7-9.4-6.5l5.3.6c1 .9 2.3 1.5 3.7 1.8l.4-1.3c-2.5-.8-4.5-3-5-5.7h2.1c.8 2.3 3 4 5.5 4 1.1 0 2.2-.3 3.1-.9l1.9 1.9c-1.4.9-3 1.4-4.7 1.4-4.1 0-7.5-3.3-7.5-7.4 0-3.8 2.9-7 6.6-7.4l.4-1.4C7.3 3.1 3.7 6.6 3.7 11c0 4.6 3.7 8.4 8.3 8.4 4.6 0 8.4-3.7 8.4-8.3H21v1.5h-1.6z"/></svg>
                                                        @elseif(str_contains(strtolower($device['browser']), 'firefox'))
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8 0-3.3 2.1-6.3 5.3-7.5.3-.5.7-.8 1.2-.8 1.7 0 1.3 1.1 2.3 2.4 2.3.3 0 .6-.1.9-.2.4 1.7 1.9 3 3.7 3 .8 0 1.5-.2 2.1-.6.6 1.8 2.3 3.1 4.3 3.1 0 .1-1.1 1.7-3.5 2.6-2.4.9-5.3.9-7.8 0-2.4-.9-3.5-2.5-3.5-2.6 1.4-.5 2.6-1.4 3.4-2.6-1.7-.7-2.9-2.4-2.9-4.3 0-1.1.5-2.1 1.2-2.8-.4-.1-.8-.2-1.2-.2-1.7 0-3 1.3-3 3 0 .6.2 1.2.5 1.7C4.2 9.3 4 8.7 4 8c0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2.6-.2 1.2-.3 1.8-.3.9 0 1.8.2 2.6.6.4-.5.9-.9 1.5-1.2.2-.1.4-.2.6-.2.4 0 .7.3.7.7 0 .3-.2.5-.5.6-1.6.6-2.9 1.8-3.5 3.4.5.2.9.5 1.4.5 1.9 0 3.3-2.7 6-6 6z"/></svg>
                                                        @endif
                                                        {{ $device['browser'] }}
                                </span>
                                                @endif
                                                @if($device['type'] ?? false)
                                                    <span class="inline-flex items-center bg-gray-100 px-2 py-0.5 rounded text-[10px]">
                                    {{ ucfirst($device['type']) }}
                                </span>
                                                @endif
                                            </div>
                                            <div class="mt-1 text-[10px] text-gray-500">
                                                {{ $ipDetails['ip'] }}
                                                @if($ipDetails['forwarded_for'])
                                                    <span class="text-gray-400">(via {{ $ipDetails['forwarded_for'] }})</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-gray-400">Unknown device</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

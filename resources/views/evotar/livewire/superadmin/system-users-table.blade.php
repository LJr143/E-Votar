<div>
    <div class="hidden sm:block mb-4">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="$set('filter', 'all_users')"
                        class=" whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'all_users' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All System User
                </button>
                <button wire:click="$set('filter', 'admin')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'admin' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Administrators
                </button>
                <button wire:click="$set('filter', 'watcher')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'watcher' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Election Watchers
                </button>
                <button wire:click="$set('filter', 'technical_officer')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'technical_officer' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Technical Officers
                </button>
            </nav>
        </div>
    </div>
    <div class="flex w-full gap-4 min">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex flex-col md:flex-row w-full items-center justify-between">
                        <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                            <button
                                class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                wire:click="exportSystemUsers"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove wire:target="exportSystemUsers"
                                     xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                     width="20px" fill="#000000">
                                    <path
                                        d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                </svg>
                                <span wire:loading.remove wire:target="exportSystemUsers" class="text-[12px]">Export List of Voters</span>
                                <svg wire:loading wire:target="exportSystemUsers" class="animate-spin h-5 w-5 mr-3"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading wire:target="exportSystemUsers">Exporting...</span>
                            </button>
                        </div>
                        <div class="w-1/2 flex justify-end">
                            @can('create users')
                                <livewire:manage-system-user.add-system-user/>
                            @endcan
                            <div class="relative w-[250px] mb-4">
                                <!-- Search Input -->
                                <input type="text" wire:model.live="search"
                                       class="rounded h-[30px] text-[12px] border border-gray-400 pl-10 pr-4 focus:border-black focus:ring focus:ring-black-[1px] w-full"
                                       placeholder="Search..." aria-label="Search">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z"
                                          fill="#868FA0"/>
                                </svg>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 min-h-[400px]">
                        <table class="min-w-full ">
                            <thead>
                            <tr>
                                <th class="font-bold text-[10px] text-left px-4 py-3"><input type="checkbox" class="rounded"></th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">User Id</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">Full Name</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">Access Role</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">Email</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">Year Level</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">College</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3">Program</th>
                                <th class="font-bold text-[10px] text-left px-4 py-3"></th>
                            </tr>
                            </thead>
                            <tr></tr>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="font-light text-[10px]">
                                    <td class="px-4 py-1"><input type="checkbox" class="rounded"></td>
                                    <td class="px-4 py-1">{{ $user->id }}</td>
                                    <td class="px-4 py-1">
                                        {{ $user->first_name }}
                                        {{ $user->middle_initial ? $user->middle_initial . '. ' : '' }}
                                        {{ $user->last_name }}
                                        {{ optional($user->extension)->name ?? '' }}
                                    </td>

                                    <td class="px-4 py-1 capitalize">
                                        @foreach ($user->roles as $role)
                                            {{ $role->name }}@if (!$loop->last)
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-1">{{ $user->email }}</td>
                                    <td class="px-4 py-1 ">{{ $user->year_level  . ' Year' }}</td>
                                    <td class="px-4 py-1 ">{{ $user->college->name }}</td>
                                    <td class="px-4 py-1">
                                        @php
                                            $programName = $user->program->name;
                                            $programName = str_starts_with($programName, 'Bachelor of Science') ? 'BS ' . substr($programName, strlen('Bachelor of Science')) : $programName;
                                        @endphp
                                        <span class="program-name" title="{{ $programName }}">
                                                {{ strlen($programName) > 15 ? substr($programName, 0, 15) . '...' : $programName }}
                                            </span>
                                    </td>
                                    <td class="px-4 py-1 text-center flex">
                                        @can('edit users')
                                        <livewire:manage-system-user.edit-user :user_id="$user->id"
                                                                               :key="'edit-system-user'.$user->id"/>
                                        @endcan
                                        @can('delete users')
                                        <livewire:manage-system-user.delete-user :user_id="$user->id"
                                                                                 :key="'delete-system-user'.$user->id"/>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

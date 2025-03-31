<div>
    <div class="overflow-x-auto sm:overflow-visible block mb-4">
        <div class="border-b-2 border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <!-- "All Campuses" Button -->
                <button wire:click="$set('filter', 'All Campus')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === 'All Campus' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All Campuses
                </button>

                <!-- Dynamically Generated Campus Buttons -->
                @foreach($campusList as $campus)
                    <button wire:click="$set('filter', '{{ $campus->name }}')"
                            class="whitespace-nowrap border-b-2 pb-1 px-1 text-[12px] font-medium {{ $filter === $campus->name ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                        {{ $campus->name }}
                    </button>
                @endforeach
            </nav>

        </div>
    </div>
    <div class="flex w-full gap-4 min">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex w-full">
                        <div class="w-1/2">
                            <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                    <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                </svg>
                                <span class="text-[12px]">Export</span>
                            </button>
                        </div>
                        <div class="w-1/2 flex justify-end">
                            <div class="w-full md:w-[250px]">
                                <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                                    <span class="flex items-center">
                                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                        </svg>
                                    </span>
                                    <x-input type="text" wire:model.live="search"
                                             class="text-[10px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full px-2"
                                             placeholder="Search elections..." aria-label="Search">
                                    </x-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 min-h-[400px]">
                        <div class="space-y-6">
                            @foreach($programs as $program)
                                <div x-data="{ open: false }" class="bg-white shadow-lg rounded-lg p-4" wire:key="program-{{ $program->id }}">
                                    <!-- College Header -->
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-[14px] font-bold">{{ $program->name }}</h2>

                                        <!-- Hide Edit Button if No Programs -->
                                        <div class="flex">
                                            <div>
                                                <livewire:manage-program-major.add-program-major :programId="$program->id" :key="'add-program-major-'.$program->id" />
                                            </div>
                                            @if($program->majors->count() > 0)
                                                <button
                                                    @click="open = !open"
                                                    class="bg-black text-white px-3 text-[12px] py-1 rounded hover:bg-gray-950">
                                                    Edit
                                                </button>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Program List (Always Visible, Only Hide Action Buttons Initially) -->
                                    <div class="mt-3 text-[12px]">
                                        @if($program->majors->count() > 0)
                                            @foreach($program->majors as $major)
                                                <div class="bg-gray-100 p-3 rounded mt-2 flex justify-between items-center" wire:key="program-major-{{ $major->id }}">
                                                    <span>{{ $major->name }}</span>
                                                    <!-- Action Buttons (Hidden by Default, Shown When Campus Edit is Clicked) -->
                                                    <div x-show="open" class="flex space-x-2" x-cloak>
                                                        <livewire:manage-program-major.edit-program-major :programMajorId="$major->id" :key="'edit-program-major-'.$major->id"/>
                                                        <livewire:manage-program-major.delete-program-major :programMajorId="$major->id" :key="'delete-program-major-'.$major->id"/>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Message when no colleges exist -->
                                            <p class="text-gray-500 italic text-center mt-2">No currently added major / specialization for this program</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $programs->links('evotar.components.pagination.tailwind-pagination') }}
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
                printable: 'collegeTable',
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

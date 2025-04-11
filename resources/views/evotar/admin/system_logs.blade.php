<x-app-layout mainClass="flex" page_title="- System Logs">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col w-full md:w-1/2 lg:w-1/3">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">System Logs</h1>
                            <p class="text-[11px] text-gray-500">List of Actions and Activities of USeP E-votar system users</p>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="flex w-full gap-4 min">
                    <div id="all_elections" class="w-full">
                        <div class="bg-white shadow-md rounded p-6">
                            <div class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">

                                <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                                    <div class="flex space-x-2">
                                        <button class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000">
                                                <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                                            </svg>
                                            <span class="text-[12px]">Export</span>
                                        </button>
                                    </div>
                                   <div class="flex flex-col sm:flex-row sm:justify-center gap-3 md:gap-3 w-full md:w-auto mt-2 relative z-50">
                                    <div class="relative w-full sm:w-[250px] mb-4">
                                        <input type="text" placeholder="Search..." aria-label="Search"
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
                                    <table class="min-w-full ">
                                        <thead>
                                        <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                            <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-black" x-model="selectAll" @click="checkboxes.forEach(checkbox => checkbox.checked = $event.target.checked)">
                                            </th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">User ID</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Name</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">College</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Program</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Major</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Year Level</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Timestamp</th>
                                            <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300">Logs</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black text-[12px] font-light">
                                        <tr class="border-b border-gray-100 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                                            </td>
                                            <td class="py-3 px-6 text-left">87364523</td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">Brooklyn Simmons</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">College of Teacher Education and Technology</td>
                                            <td class="py-3 px-6 text-left">Bachelor of Science in Information Technology</td>
                                            <td class="py-3 px-6 text-left">Information Security</td>
                                            <td class="py-3 px-6 text-left">3rd Year</td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">21/12/2022</div>
                                                <div class="text-gray-500 text-[11px]">10:40:00 PM</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">Activity</td>
                                        </tr>

                                        <tr class="border-b border-gray-100 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                                            </td>
                                            <td class="py-3 px-6 text-left">87364523</td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">Brooklyn Simmons</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">College of Teacher Education and Technology</td>
                                            <td class="py-3 px-6 text-left">Bachelor of Science in Information Technology</td>
                                            <td class="py-3 px-6 text-left">Information Security</td>
                                            <td class="py-3 px-6 text-left">3rd Year</td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">21/12/2022</div>
                                                <div class="text-gray-500 text-[11px]">10:40:00 PM</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">Activity</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

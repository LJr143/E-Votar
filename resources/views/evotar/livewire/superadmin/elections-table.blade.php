<div>
    <div class="hidden sm:block mb-4">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="$set('filter', 'all_elections')"
                        class=" whitespace-nowrap border-b-2 pb-1 px-1 text-xs font-medium {{ $filter === 'all_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    All Elections
                </button>
                <button wire:click="$set('filter', 'ongoing_elections')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-xs font-medium {{ $filter === 'ongoing_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Ongoing
                </button>
                <button wire:click="$set('filter', 'completed_elections')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-xs font-medium {{ $filter === 'completed_elections' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Completed
                </button>
            </nav>
        </div>
    </div>
    <div class="flex w-full gap-4 min">
        <div id="all_elections" class="w-full">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex w-full">
                        <div class="w-1/2">
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_782_22521" style="mask-type:alpha"
                                          maskUnits="userSpaceOnUse"
                                          x="0" y="0" width="24" height="24">
                                        <rect width="24" height="24" fill="#D9D9D9"/>
                                    </mask>
                                    <g mask="url(#mask0_782_22521)">
                                        <path
                                            d="M8.30826 20.4998C7.81115 20.4998 7.38559 20.3228 7.03159 19.9688C6.67757 19.6148 6.50056 19.1893 6.50056 18.6921V16.4998H4.59674C4.09962 16.4998 3.67406 16.3228 3.32006 15.9688C2.96606 15.6148 2.78906 15.1893 2.78906 14.6921V10.8075C2.78906 10.0992 3.03105 9.50548 3.51501 9.02632C3.99898 8.54717 4.59031 8.30759 5.28901 8.30759H18.7121C19.4204 8.30759 20.0141 8.54717 20.4933 9.02632C20.9724 9.50548 21.212 10.0992 21.212 10.8075V14.6921C21.212 15.1893 21.035 15.6148 20.681 15.9688C20.327 16.3228 19.9015 16.4998 19.4043 16.4998H17.5005V18.6921C17.5005 19.1893 17.3235 19.6148 16.9695 19.9688C16.6155 20.3228 16.1899 20.4998 15.6928 20.4998H8.30826ZM4.59674 14.9999H6.50056C6.5134 14.514 6.69493 14.0976 7.04516 13.7508C7.3954 13.404 7.81643 13.2306 8.30826 13.2306H15.6928C16.1846 13.2306 16.6057 13.404 16.9559 13.7508C17.3061 14.0976 17.4877 14.514 17.5005 14.9999H19.4043C19.4941 14.9999 19.5678 14.971 19.6255 14.9133C19.6832 14.8556 19.7121 14.7819 19.7121 14.6921V10.8075C19.7121 10.5242 19.6162 10.2867 19.4246 10.095C19.2329 9.90338 18.9954 9.80754 18.7121 9.80754H5.28901C5.00568 9.80754 4.76818 9.90338 4.57651 10.095C4.38485 10.2867 4.28901 10.5242 4.28901 10.8075V14.6921C4.28901 14.7819 4.31786 14.8556 4.37556 14.9133C4.43326 14.971 4.50699 14.9999 4.59674 14.9999ZM16.0005 8.30759V5.61529C16.0005 5.52554 15.9717 5.45182 15.914 5.39412C15.8563 5.33643 15.7826 5.30759 15.6928 5.30759H8.30826C8.21851 5.30759 8.14479 5.33643 8.08709 5.39412C8.02939 5.45182 8.00054 5.52554 8.00054 5.61529V8.30759H6.50056V5.61529C6.50056 5.11819 6.67757 4.69263 7.03159 4.33862C7.38559 3.98462 7.81115 3.80762 8.30826 3.80762H15.6928C16.1899 3.80762 16.6155 3.98462 16.9695 4.33862C17.3235 4.69263 17.5005 5.11819 17.5005 5.61529V8.30759H16.0005ZM17.8082 12.3075C18.0915 12.3075 18.329 12.2117 18.5207 12.02C18.7124 11.8284 18.8082 11.5909 18.8082 11.3075C18.8082 11.0242 18.7124 10.7867 18.5207 10.595C18.329 10.4034 18.0915 10.3075 17.8082 10.3075C17.5249 10.3075 17.2874 10.4034 17.0957 10.595C16.904 10.7867 16.8082 11.0242 16.8082 11.3075C16.8082 11.5909 16.904 11.8284 17.0957 12.02C17.2874 12.2117 17.5249 12.3075 17.8082 12.3075ZM16.0005 18.6921V15.0383C16.0005 14.9486 15.9717 14.8749 15.914 14.8172C15.8563 14.7595 15.7826 14.7306 15.6928 14.7306H8.30826C8.21851 14.7306 8.14479 14.7595 8.08709 14.8172C8.02939 14.8749 8.00054 14.9486 8.00054 15.0383V18.6921C8.00054 18.7819 8.02939 18.8556 8.08709 18.9133C8.14479 18.971 8.21851 18.9999 8.30826 18.9999H15.6928C15.7826 18.9999 15.8563 18.971 15.914 18.9133C15.9717 18.8556 16.0005 18.7819 16.0005 18.6921Z"
                                            fill="#35353A"/>
                                    </g>
                                </svg>
                            </button>
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                <svg width="12" height="18" viewBox="0 0 22 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 1H1L9 10.46V17L13 19V10.46L21 1Z" stroke="#534D59"
                                          stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                            </button>
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                <svg width="12" height="18" viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="#534D59" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="w-1/2 flex justify-end">
                            <livewire:superadmin.add-election/>
                            <div class="relative w-[250px] mb-4">
                                <!-- Search Input -->
                                <input type="text" wire:model.live="search"
                                       class="rounded h-[28px] text-[10px] border border-gray-400 pl-10 pr-4 focus:border-black focus:ring focus:ring-black-[1px] w-full"
                                       placeholder="Search..." aria-label="Search">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z"
                                          fill="#868FA0"/>
                                </svg>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 min-h-[350px]">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50 text-left text-[12px] ">
                            <tr class="">
                                <th class="border border-gray-300 px-4 py-2 font-light">Election ID</th>
                                <th class="border border-gray-300 px-4 py-2 font-light">Election</th>
                                <th class="border border-gray-300 px-4 py-2 font-light">Election Type</th>
                                <th class="border border-gray-300 px-4 py-2 font-light">Date Started</th>
                                <th class="border border-gray-300 px-4 py-2 font-light">Date Ended</th>
                                <th class="border border-gray-300 px-4 py-2 font-light text-left">Status</th>
                                <th class="border border-gray-300 px-4 py-2 font-light text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($elections as $election)
                                <tr class="text-[12px] font-light">
                                    <td class="border border-gray-300 px-4 py-1">{{ $election->id }}</td>
                                    <td class="border border-gray-300 px-4 py-1">{{ $election->name }}</td>
                                    <td class="border border-gray-300 px-4 py-1">{{ $election->election_type->name }}</td>
                                    <td class="border border-gray-300 px-4 py-1">{{ $election->date_started }}</td>
                                    <td class="border border-gray-300 px-4 py-1">{{ $election->date_ended }}</td>
                                    <td class="border border-gray-300 px-4 py-1 text-white text-center"><p
                                            class="bg-green-600 w-[60px] rounded">
                                            {{ $election->status }}</p></td>
                                    <td class="border border-gray-300 px-4 py-1 text-center">
                                        <button
                                            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4 21.6003H5.39999C4.0745 21.6003 2.99999 20.5258 3 19.2003L3.00009 4.80038C3.0001 3.4749 4.07462 2.40039 5.40009 2.40039H16.2004C17.5258 2.40039 18.6004 3.47491 18.6004 4.80039V9.60039M19.8 19.8004L21 21.0004M7.20037 7.20039H14.4004M7.20037 10.8004H14.4004M7.20037 14.4004H10.8004M20.4 17.4004C20.4 19.0572 19.0569 20.4004 17.4 20.4004C15.7431 20.4004 14.4 19.0572 14.4 17.4004C14.4 15.7435 15.7431 14.4004 17.4 14.4004C19.0569 14.4004 20.4 15.7435 20.4 17.4004Z"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>

                                        </button>
                                        <button
                                            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                            <svg width="14" height="18" viewBox="0 0 17 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.49997 15.5H2.7615L12.9981 5.2634L11.7366 4.00188L1.49997 14.2385V15.5ZM0.90385 17C0.647767 17 0.433108 16.9133 0.259875 16.7401C0.0866248 16.5668 0 16.3522 0 16.0961V14.3635C0 14.1196 0.0467999 13.8871 0.1404 13.6661C0.233983 13.4451 0.362825 13.2526 0.526925 13.0885L13.1904 0.430775C13.3416 0.293426 13.5086 0.187292 13.6913 0.112375C13.874 0.0374582 14.0656 0 14.2661 0C14.4666 0 14.6608 0.0355838 14.8488 0.10675C15.0368 0.1779 15.2032 0.291034 15.348 0.44615L16.5692 1.68268C16.7243 1.82754 16.8349 1.99424 16.9009 2.18278C16.9669 2.37129 17 2.55981 17 2.74833C17 2.94941 16.9656 3.14131 16.8969 3.32403C16.8283 3.50676 16.719 3.67373 16.5692 3.82495L3.91147 16.473C3.74738 16.6371 3.55483 16.766 3.33383 16.8596C3.11281 16.9532 2.88037 17 2.6365 17H0.90385ZM12.3563 4.6437L11.7366 4.00188L12.9981 5.2634L12.3563 4.6437Z"
                                                    fill="#35353A"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                            <svg width="15" height="17" viewBox="0 0 15 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.8077 16.9998C2.31058 16.9998 1.88502 16.8228 1.53102 16.4688C1.17701 16.1148 1 15.6892 1 15.1921V2.49981H0.75C0.5375 2.49981 0.359375 2.4279 0.215625 2.28408C0.071875 2.14028 0 1.96208 0 1.74948C0 1.5369 0.071875 1.35882 0.215625 1.21523C0.359375 1.07163 0.5375 0.999834 0.75 0.999834H4.49997C4.49997 0.754967 4.58619 0.546318 4.75863 0.373885C4.93106 0.201451 5.13971 0.115234 5.38457 0.115234H9.61538C9.86024 0.115234 10.0689 0.201451 10.2413 0.373885C10.4138 0.546318 10.5 0.754967 10.5 0.999834H14.25C14.4625 0.999834 14.6406 1.07174 14.7843 1.21556C14.9281 1.35938 15 1.53758 15 1.75016C15 1.96276 14.9281 2.14085 14.7843 2.28443C14.6406 2.42802 14.4625 2.49981 14.25 2.49981H14V15.1921C14 15.6892 13.8229 16.1148 13.4689 16.4688C13.1149 16.8228 12.6894 16.9998 12.1922 16.9998H2.8077ZM12.5 2.49981H2.49997V15.1921C2.49997 15.2818 2.52883 15.3556 2.58652 15.4133C2.64422 15.471 2.71795 15.4998 2.8077 15.4998H12.1922C12.282 15.4998 12.3557 15.471 12.4134 15.4133C12.4711 15.3556 12.5 15.2818 12.5 15.1921V2.49981ZM5.65417 13.4998C5.86676 13.4998 6.04484 13.4279 6.18842 13.2842C6.33202 13.1404 6.40382 12.9623 6.40382 12.7498V5.24979C6.40382 5.0373 6.33192 4.85918 6.1881 4.71543C6.04428 4.57168 5.86608 4.49981 5.6535 4.49981C5.4409 4.49981 5.26281 4.57168 5.11922 4.71543C4.97564 4.85918 4.90385 5.0373 4.90385 5.24979V12.7498C4.90385 12.9623 4.97576 13.1404 5.11958 13.2842C5.26337 13.4279 5.44158 13.4998 5.65417 13.4998ZM9.34645 13.4998C9.55905 13.4998 9.73714 13.4279 9.88072 13.2842C10.0243 13.1404 10.0961 12.9623 10.0961 12.7498V5.24979C10.0961 5.0373 10.0242 4.85918 9.88037 4.71543C9.73658 4.57168 9.55837 4.49981 9.34577 4.49981C9.13319 4.49981 8.95511 4.57168 8.81152 4.71543C8.66792 4.85918 8.59613 5.0373 8.59613 5.24979V12.7498C8.59613 12.9623 8.66803 13.1404 8.81185 13.2842C8.95567 13.4279 9.13387 13.4998 9.34645 13.4998Z"
                                                    fill="#35353A"/>
                                            </svg>
                                        </button>
                                    </td>
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
